<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Biodata;
use App\Models\LogPengajuan;
use App\Models\Pengajuan;
use App\Models\Skck;
use Illuminate\Http\Request;
use PDF;

class adminSkckController extends Controller
{
    /**
     * Menampilkan seluruh pengajuan skck
     */
    public function index()
    {
        return view('admin.SKCK.index', [
            'title' => 'Surat Pengantar SKCK',
            'skcks' => Skck::select('skcks.*', 'pengajuans.id AS pid')
                ->join('pengajuans', 'pengajuans.id', '=', 'skcks.pengajuan_id')
                ->get(),
        ]);
    }

    /**
     * Menampilkan satu skck
     * 
     * @param string $id id dari tabel skck (bukan dari pengajuan)
     */
    public function show(string $id)
    {
        $skck = Skck::select('skcks.*', 'pengajuans.id AS pid')
            ->join('pengajuans', 'pengajuans.id', '=', 'skcks.pengajuan_id')
            ->where('skcks.id', $id)
            ->first();

        $biodata = Biodata::where('user_id', $skck->pengajuan->user_id)->first();
        $logs    = LogPengajuan::where('pengajuan_id', $skck->pengajuan_id)->get();

        return view('admin.SKCK.show', [
            'title'   => 'Lihat Surat Pengantar SKCK',
            'biodata' => $biodata,
            'skck'    => $skck,
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
     * Menampilkan skck
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
        return redirect()->route('admin-skck-index');
    }

    /**
     * Menampilkan skck
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
        return redirect()->route('admin-skck-index');
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

        Alert::success('Berhasil', 'Pengajuan mohon di revisi');
        return redirect()->route('admin-skck-index');
    }

    /**
     * Cetak pdf
     * 
     * @param string $id id skck
     */
    public function pdf(string $id)
    {
        $skck    = Skck::where('id', $id)->first();
        $biodata = Biodata::where('user_id', $skck->pengajuan->user_id)->first();


        // Memuat view PDF tanpa menampilkan view di browser
        $pdf = PDF::loadView('admin.SKCK.pdf', compact('skck', 'biodata'));

        // Memberikan nama file PDF yang akan diunduh
        $fileName = 'Surat Keterangan Catatan Kepolisian_' . $biodata->NIK . '.pdf';

        // Menggunakan metode stream agar tidak menyimpan file sementara di server
        return $pdf->stream($fileName);


        // return view('admin.SKCK.pdf', [
        //     'skck' => $skck,
        //     'biodata' => $biodata,
        // ]);
    }
}
