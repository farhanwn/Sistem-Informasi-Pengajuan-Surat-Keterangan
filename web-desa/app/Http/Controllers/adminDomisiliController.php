<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Biodata;
use App\Models\LogPengajuan;
use App\Models\Pengajuan;
use App\Models\Domisili;
use Illuminate\Http\Request;
use PDF;

class adminDomisiliController extends Controller
{
    /**
     * Menampilkan seluruh pengajuan domisili
     */
    public function index()
    {
        return view('admin.domisili.index', [
            'title'     => 'Surat Pengantar Domisili',
            'domisilis' => Domisili::select('domisilis.*', 'pengajuans.id AS pid')
                ->join('pengajuans', 'pengajuans.id', '=', 'domisilis.pengajuan_id')
                ->get(),
        ]);
    }

    /**
     * Menampilkan satu domisili
     * 
     * @param string $id id dari tabel domisili (bukan dari pengajuan)
     */
    public function show(string $id)
    {
        $domisili = Domisili::select('domisilis.*', 'pengajuans.id AS pid')
            ->join('pengajuans', 'pengajuans.id', '=', 'domisilis.pengajuan_id')
            ->where('domisilis.id', $id)
            ->first();

        $biodata = Biodata::where('user_id', $domisili->pengajuan->user_id)->first();
        $logs    = LogPengajuan::where('pengajuan_id', $domisili->pengajuan_id)->get();

        return view('admin.domisili.show', [
            'title'    => 'Lihat Surat Pengantar Domisili',
            'biodata'  => $biodata,
            'domisili' => $domisili,
            'logs'     => $logs,
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
     * Menampilkan domisili
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
        return redirect()->route('admin-domisili-index');
    }

    /**
     * Menampilkan domisili
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
        return redirect()->route('admin-domisili-index');
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
        return redirect()->route('admin-domisili-index');
    }

    /**
     * Cetak pdf
     * 
     * @param string $id id skck
     */
    public function pdf(string $id)
    {
        // $domisili = Domisili::where('id', $id)->first();
        // $biodata  = Biodata::where('user_id', $domisili->pengajuan->user_id)->first();

        // return view('admin.domisili.pdf', [
        //     'domisili' => $domisili,
        //     'biodata' => $biodata,
        // ]);

        $domisili    = Domisili::where('id', $id)->first();
        $biodata = Biodata::where('user_id', $domisili->pengajuan->user_id)->first();


        // Memuat view PDF tanpa menampilkan view di browser
        $pdf = PDF::loadView('admin.domisili.pdf', compact('domisili', 'biodata'));

        // Memberikan nama file PDF yang akan diunduh
        $fileName = 'Surat Keterangan domisili_' . $biodata->NIK . '.pdf';

        // Menggunakan metode stream agar tidak menyimpan file sementara di server
        return $pdf->stream($fileName);
    }
}
