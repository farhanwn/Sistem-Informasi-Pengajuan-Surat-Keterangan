<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Biodata;
use App\Models\Umum;
use App\Models\LogPengajuan;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class wargaUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('warga.umum.index', [
            'title' => 'Surat Pengantar Umum',
            'umums' => Umum::select('umums.*', 'pengajuans.id AS pid')
                ->join('pengajuans', 'pengajuans.id', '=', 'umums.pengajuan_id')
                ->where('user_id', auth()->user()->id)
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warga.umum.create', [
            'title'   => 'Buat Surat Pengantar Umum',
            'biodata' => Biodata::where('user_id', auth()->user()->id)->first(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'tujuan' => 'required',
        //     'ktp'    => 'required|image|mimes:jpeg,png,jpg,svg|max:500000',
        //     'kk'     => 'required|image|mimes:jpeg,png,jpg,svg|max:500000',
        //     'akta-kelahiran' => 'required|image|mimes:jpeg,png,jpg,svg|max:500000',
        // ]);

        // if ($validator->fails()) {
        //     Alert::info('Warning', 'Validation Error');

        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        DB::beginTransaction();
        try {
            // Mendapatkan pengguna yang sedang login
            $user = auth()->user();

            $scanKtpPath  = str_replace('public/', '', Storage::putFileAs('public/scan_ktp', $request->file('ktp'), 'scan_ktp_umum' . $user->id . '.jpg'));
            $scanKkPath   = str_replace('public/', '', Storage::putFileAs('public/scan_kk', $request->file('kk'), 'scan_kk_umum' . $user->id . '.jpg'));
            $scanAktaPath = str_replace('public/', '', Storage::putFileAs('public/scan_akta', $request->file('akta-kelahiran'), 'scan_akta_umum' . $user->id . '.jpg'));
            $pengajuan = Pengajuan::create([
                'user_id'    => $user->id,
                'kode_surat' => '00/00.00/00', // TODO: ubah ini nanti
                'scan_ktp'   => $scanKtpPath,
                'scan_kk'    => $scanKkPath,
                'scan_akta'  => $scanAktaPath,
            ]);
            // dd($pengajuan);

            Umum::create([
                'pengajuan_id' => $pengajuan->id,
                'keterangan'   => $request->keterangan,
                'tujuan'       => $request->tujuan,
            ]);

            LogPengajuan::create([
                'pengajuan_id' => $pengajuan->id,
                'status'  => 0,
                'user_id' => $user->id,
                'catatan' => 'Buat pengajuan baru',
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil Mengajukan Surat');
            return redirect(route('umum-index'));
        } catch (\Throwable $th) {
            DB::rollBack();

            // dd($th);

            Alert::error('Error', 'Gagal Menambahkan');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param string $id id dari tabel umums (bukan dari tabel pengajuan)
     */
    public function edit(string $id)
    {
        return view('warga.umum.edit', [
            'title'   => 'Edit Surat Pengantar Umum',
            'biodata' => Biodata::where('user_id', auth()->user()->id)->first(),
            'umum'    => Umum::where('id', $id)->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $user        = auth()->user(); // Mendapatkan pengguna yang sedang login
            $umum        = Umum::where('id', $id);
            $scanFiles   = [];
            $editedFiles = [];

            $scanFiles['ktp']  = str_replace('public/', '', Storage::putFileAs('public/scan_ktp', $request->file('ktp'), 'scan_ktp_umum' . $user->id . '.jpg'));
            $scanFiles['kk']   = str_replace('public/', '', Storage::putFileAs('public/scan_kk', $request->file('kk'), 'scan_kk_umum' . $user->id . '.jpg'));
            $scanFiles['akta'] = str_replace('public/', '', Storage::putFileAs('public/scan_akta', $request->file('akta-kelahiran'), 'scan_akta_umum' . $user->id . '.jpg'));

            // Hanya ambil path dari file yang diupload
            // karena saat edit tidak harus upload semua file, bisa hanya satu file saja
            foreach ($scanFiles as $file => $path) {
                if (!is_null($path)) {
                    $editedFiles['scan_' . $file] = $path;
                }
            }

            if (!empty($editedFiles)) {
                Pengajuan::where('id', $umum->first()->pengajuan_id)->update($editedFiles);
            }

            $umum->update([
                'keterangan' => $request->keterangan,
                'tujuan'     => $request->tujuan,
            ]);

            LogPengajuan::create([
                'pengajuan_id' => $umum->first()->pengajuan_id,
                'status'  => 0,
                'user_id' => $user->id,
                'catatan' => 'Ubah pengajuan',
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil Mengubah Surat');
            return redirect(route('umum-index'));
        } catch (\Throwable $th) {
            DB::rollBack();

            // dd($th);

            Alert::error('Error', 'Gagal Mengedit');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
