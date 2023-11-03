<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Biodata;
use App\Models\Domisili;
use App\Models\LogPengajuan;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class wargaDomisiliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('warga.domisili.index', [
            'title'     => 'Surat Pengantar Domisili',
            'domisilis' => Domisili::select('domisilis.*', 'pengajuans.id AS pid')
                ->join('pengajuans', 'pengajuans.id', '=', 'domisilis.pengajuan_id')
                ->where('user_id', auth()->user()->id)
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warga.domisili.create', [
            'title'   => 'Buat Surat Pengantar Domisili',
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


            $scanKtpPath  = str_replace('public/', '', Storage::putFileAs('public/scan_ktp', $request->file('ktp'), 'scan_ktp_domisili' . $user->id . '.jpg'));
            $scanKkPath   = str_replace('public/', '', Storage::putFileAs('public/scan_kk', $request->file('kk'), 'scan_kk_domisili' . $user->id . '.jpg'));
            $scanAktaPath = str_replace('public/', '', Storage::putFileAs('public/scan_akta', $request->file('akta-kelahiran'), 'scan_akta_domisili' . $user->id . '.jpg'));

            $pengajuan = Pengajuan::create([
                'user_id'    => $user->id,
                'kode_surat' => '00/00.00/00', // TODO: ubah ini nanti
                'scan_ktp'   => $scanKtpPath,
                'scan_kk'    => $scanKkPath,
                'scan_akta'  => $scanAktaPath,
            ]);
            // dd($pengajuan);

            Domisili::create([
                'pengajuan_id' => $pengajuan->id,
                'domisili'     => $request->domisili,
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
            return redirect(route('domisili-index'));
        } catch (\Throwable $th) {
            DB::rollBack();

            // dd($th)

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
     * @param string $id id dari tabel domisilis (bukan dari tabel pengajuan)
     */
    public function edit(string $id)
    {
        return view('warga.domisili.edit', [
            'title'     => 'Edit Surat Pengantar Domisili',
            'biodata'   => Biodata::where('user_id', auth()->user()->id)->first(),
            'domisili' => Domisili::where('id', $id)->first(),
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
            $domisili    = Domisili::where('id', $id);
            $scanFiles   = [];
            $editedFiles = [];

            $scanFiles['ktp']  = str_replace('public/', '', Storage::putFileAs('public/scan_ktp', $request->file('ktp'), 'scan_ktp_domisili' . $user->id . '.jpg'));
            $scanFiles['kk']   = str_replace('public/', '', Storage::putFileAs('public/scan_kk', $request->file('kk'), 'scan_kk_domisili' . $user->id . '.jpg'));
            $scanFiles['akta'] = str_replace('public/', '', Storage::putFileAs('public/scan_akta', $request->file('akta-kelahiran'), 'scan_akta_domisili' . $user->id . '.jpg'));

            // Hanya ambil path dari file yang diupload
            // karena saat edit tidak harus upload semua file, bisa hanya satu file saja
            foreach ($scanFiles as $file => $path) {
                if (!is_null($path)) {
                    $editedFiles['scan_' . $file] = $path;
                }
            }

            if (!empty($editedFiles)) {
                Pengajuan::where('id', $domisili->first()->pengajuan_id)->update($editedFiles);
            }

            $domisili->update([
                'domisili' => $request->domisili,
                'tujuan'   => $request->tujuan,
            ]);

            LogPengajuan::create([
                'pengajuan_id' => $domisili->first()->pengajuan_id,
                'status'  => 0,
                'user_id' => $user->id,
                'catatan' => 'Ubah pengajuan',
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil Mengubah Surat');
            return redirect(route('domisili-index'));
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
