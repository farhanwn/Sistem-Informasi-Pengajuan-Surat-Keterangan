<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Biodata;
use App\Models\LogPengajuan;
use App\Models\Pengajuan;
use App\Models\Umum;
use Illuminate\Http\Request;
use PDF;

class adminUmumController extends Controller
{
    /**
     * Menampilkan seluruh pengajuan umum
     */
    public function index()
    {
        return view('admin.umum.index', [
            'title' => 'Surat Pengantar Umum',
            'umums' => Umum::select('umums.*', 'pengajuans.id AS pid')
                ->join('pengajuans', 'pengajuans.id', '=', 'umums.pengajuan_id')
                ->get(),
        ]);
    }

    /**
     * Menampilkan satu umum
     * 
     * @param string $id id dari tabel umum (bukan dari pengajuan)
     */
    public function show(string $id)
    {
        $umum = Umum::select('umums.*', 'pengajuans.id AS pid')
            ->join('pengajuans', 'pengajuans.id', '=', 'umums.pengajuan_id')
            ->where('umums.id', $id)
            ->first();

        $biodata = Biodata::where('user_id', $umum->pengajuan->user_id)->first();
        $logs    = LogPengajuan::where('pengajuan_id', $umum->pengajuan_id)->get();

        return view('admin.umum.show', [
            'title'   => 'Lihat Surat Pengantar Umum',
            'biodata' => $biodata,
            'umum'    => $umum,
            'logs'    => $logs,
        ]);
    }

    /**
     * Memberikan comment atau catatan pengajuan
     * 
     * @param string $id id pengajuan
     */
    public function comment(string $id, Request $request)
    {
        $pengajuan = Pengajuan::select('status')->where('id', $id)->first();

        LogPengajuan::create([
            'pengajuan_id' => $id,
            'status'  => $pengajuan->status,
            'user_id' => auth()->user()->id,
            'catatan' => $request->catatan ?? '',
        ]);

        Alert::info('Berhasil', 'Catatan telah ditambahkan');
        return redirect()->back();
    }

    /**
     * Menampilkan umum
     * 
     * @param string $id id pengajuan
     */
    public function approve(string $id)
    {
        Pengajuan::where('id', $id)->update([
            'status' => 1,
        ]);

        LogPengajuan::create([
            'pengajuan_id' => $id,
            'status'       => 1,
            'user_id'      => auth()->user()->id,
        ]);

        Alert::success('Berhasil', 'Pengajuan telah diterima');
        return redirect()->route('admin-umum-index');
    }

    /**
     * Menampilkan umum
     * 
     * @param string $id id pengajuan
     */
    public function reject(string $id)
    {
        Pengajuan::where('id', $id)->update([
            'status' => 2,
        ]);

        LogPengajuan::create([
            'pengajuan_id' => $id,
            'status'       => 2,
            'user_id'      => auth()->user()->id,
        ]);

        Alert::success('Berhasil', 'Pengajuan telah ditolak');
        return redirect()->route('admin-umum-index');
    }
    public function revisi(string $id)
    {
        Pengajuan::where('id', $id)->update([
            'status' => 3,
        ]);

        LogPengajuan::create([
            'pengajuan_id' => $id,
            'status'       => 3,
            'user_id'      => auth()->user()->id,
        ]);

        Alert::success('Berhasil', 'Pengajuan telah ditolak');
        return redirect()->route('admin-umum-index');
    }

    /**
     * Cetak pdf
     * 
     * @param string $id id umum
     */
    public function pdf(string $id)
    {
        // $umum    = Umum::where('id', $id)->first();
        // $biodata = Biodata::where('user_id', $umum->pengajuan->user_id)->first();

        // return view('admin.umum.pdf', [
        //     'umum' => $umum,
        //     'biodata' => $biodata,
        // ]);

        $umum    = Umum::where('id', $id)->first();
        $biodata = Biodata::where('user_id', $umum->pengajuan->user_id)->first();


        // Memuat view PDF tanpa menampilkan view di browser
        $pdf = PDF::loadView('admin.umum.pdf', compact('umum', 'biodata'));

        // Memberikan nama file PDF yang akan diunduh
        $fileName = 'Surat Keterangan_' . $biodata->NIK . '.pdf';

        // Menggunakan metode stream agar tidak menyimpan file sementara di server
        return $pdf->stream($fileName);
    }
}
