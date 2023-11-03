<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Biodata;
use App\Models\LogPengajuan;
use App\Models\Pengajuan;
use App\Models\Skck;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class wargaSkckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('warga.SKCK.index', [
            'title' => 'Surat Pengantar SKCK',
            'skcks' => Skck::select('skcks.*', 'pengajuans.id AS pid')
                ->join('pengajuans', 'pengajuans.id', '=', 'skcks.pengajuan_id')
                ->where('user_id', auth()->user()->id)
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warga.SKCK.create', [
            'title'   => 'Buat Surat Pengantar SKCK',
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

        \Carbon\Carbon::setLocale('id');

        DB::beginTransaction();
        try {
            // Mendapatkan pengguna yang sedang login
            $user = auth()->user();

            $scanKtpPath  = str_replace('public/', '', Storage::putFileAs('public/scan_ktp', $request->file('ktp'), 'scan_ktp_' . $user->id . '.jpg'));
            $scanKkPath   = str_replace('public/', '', Storage::putFileAs('public/scan_kk', $request->file('kk'), 'scan_kk_' . $user->id . '.jpg'));
            $scanAktaPath = str_replace('public/', '', Storage::putFileAs('public/scan_akta', $request->file('akta-kelahiran'), 'scan_akta_' . $user->id . '.jpg'));

            $pengajuan = Pengajuan::create([
                'user_id'    => $user->id,
                'kode_surat' => $this->generateKodeSurat(),
                'scan_ktp'   => $scanKtpPath,
                'scan_kk'    => $scanKkPath,
                'scan_akta'  => $scanAktaPath,
            ]);

            Skck::create([
                'pengajuan_id' => $pengajuan->id,
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
            return redirect(route('skck-index'));
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error('Error', 'Gagal Menambahkan');
            return redirect()->back();
        }
    }

    // Function to generate the letter number
    function generateKodeSurat()
    {
        // You can implement your own logic to generate the letter number
        // For example, you can use the current date and user ID
        $date = now();
        $user = auth()->user();
        $formattedDate = $date->format('Y');

        return "145/737/418.60.{$user->id}/{$formattedDate}"; // Adjust this format as needed
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
     * @param string $id id dari tabel skcks (bukan dari tabel pengajuan)
     */
    public function edit(string $id)
    {
        return view('warga.SKCK.edit', [
            'title'   => 'Edit Surat Pengantar SKCK',
            'biodata' => Biodata::where('user_id', auth()->user()->id)->first(),
            'skck'    => Skck::where('id', $id)->first(),
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
            $skck        = Skck::where('id', $id);
            $scanFiles   = [];
            $editedFiles = [];

            $scanFiles['ktp']  = str_replace('public/', '', Storage::putFileAs('public/scan_ktp', $request->file('ktp'), 'scan_ktp_' . $user->id . '.jpg'));
            $scanFiles['kk']   = str_replace('public/', '', Storage::putFileAs('public/scan_kk', $request->file('kk'), 'scan_kk_' . $user->id . '.jpg'));
            $scanFiles['akta'] = str_replace('public/', '', Storage::putFileAs('public/scan_akta', $request->file('akta-kelahiran'), 'scan_akta_' . $user->id . '.jpg'));

            // Hanya ambil path dari file yang diupload
            // karena saat edit tidak harus upload semua file, bisa hanya satu file saja
            foreach ($scanFiles as $file => $path) {
                if (!is_null($path)) {
                    $editedFiles['scan_' . $file] = $path;
                }
            }

            if (!empty($editedFiles)) {
                Pengajuan::where('id', $skck->first()->pengajuan_id)->update($editedFiles);
            }

            $skck->update([
                'tujuan' => $request->tujuan,
            ]);

            LogPengajuan::create([
                'pengajuan_id' => $skck->first()->pengajuan_id,
                'status'  => 0,
                'user_id' => $user->id,
                'catatan' => 'Ubah pengajuan',
            ]);

            DB::commit();

            Alert::success('Berhasil', 'Berhasil Mengubah Surat');
            return redirect(route('skck-index'));
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
