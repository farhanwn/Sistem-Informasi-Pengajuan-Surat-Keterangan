@extends('layouts.main')

@section('content')
<h1><strong>Dashboard</strong></h1>
<h4>Hallo, <span class="text-dark"><strong>{{Auth::user()->name}}</strong></span></h4>
<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Approved</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jml_approve }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Waiting</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jml_waiting }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-contract fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            reject</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jml_reject }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-excel fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            User Guide</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <span class="h4">Pengajuan SKCK Belum Di-<i lang="en" title="terima">approve</i></span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Tanggal Pengajuan</th>
                                <th class="text-center">Keperluan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($skcks as $skck)
                            <tr>
                                <td>{{ $loop->iteration.'.' }}</td>
                                <td class="text-center">{{ $skck->pengajuan->created_at }}</td>
                                <td class="text-center">{{ $skck->tujuan }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin-skck-show', $skck->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <span class="h4">Pengajuan Surat Domisili Belum Di-<i lang="en" title="terima">approve</i></span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Tanggal Pengajuan</th>
                                <th class="text-center">Keperluan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($domisilis as $domisili)
                            <tr>
                                <td>{{ $loop->iteration.'.' }}</td>
                                <td class="text-center">{{ $domisili->pengajuan->created_at }}</td>
                                <td class="text-center">{{ $domisili->tujuan }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin-domisili-show', $domisili->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <span class="h4">Pengajuan Surat Umum Belum Di-<i lang="en" title="terima">approve</i></span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Tanggal Pengajuan</th>
                                <th class="text-center">Keperluan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($umums as $umum)
                            <tr>
                                <td>{{ $loop->iteration.'.' }}</td>
                                <td class="text-center">{{ $umum->pengajuan->created_at }}</td>
                                <td class="text-center">{{ $umum->tujuan }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin-umum-show', $umum->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection