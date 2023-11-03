<?php

namespace App\Http\Controllers;

use App\Models\Domisili;
use App\Models\Pengajuan;
use App\Models\Skck;
use App\Models\Umum;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'jml_waiting' => Pengajuan::where('status', 0)->get()->count(),
            'jml_approve' => Pengajuan::where('status', 1)->get()->count(),
            'jml_reject'  => Pengajuan::where('status', 2)->get()->count(),
            'skcks' => Skck::select('skcks.*', 'pengajuans.id AS pid')
                ->join('pengajuans', 'pengajuans.id', '=', 'skcks.pengajuan_id')
                ->where('status', 0)
                ->get(),
            'domisilis' => Domisili::select('domisilis.*', 'pengajuans.id AS pid')
                ->join('pengajuans', 'pengajuans.id', '=', 'domisilis.pengajuan_id')
                ->where('status', 0)
                ->get(),
            'umums' => Umum::select('umums.*', 'pengajuans.id AS pid')
                ->join('pengajuans', 'pengajuans.id', '=', 'umums.pengajuan_id')
                ->where('status', 0)
                ->get(),
        ]);
    }
}
