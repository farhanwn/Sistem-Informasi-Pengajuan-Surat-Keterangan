@extends('layouts.main')

@section('content')
<div class="card mb-4 mt-5">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2 mt-2">
            <h3 class="text-secondary"><strong>Surat Pengantar Domisili</strong></h3>
        </div>
        <div class="table-responsive">
            <table id="userTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th class="text-center">Tanggal Pengajuan</th>
                        <th class="text-center">Keperluan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($domisilis as $domisili)
                    <tr>
                        <td>{{ $loop->iteration.'.' }}</td>
                        <td class="text-center">{{ $domisili->pengajuan->created_at }}</td>
                        <td class="text-center">{{ $domisili->tujuan }}</td>
                        <td class="text-center">{{ status($domisili->pengajuan->status) }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin-domisili-show', $domisili->id) }}" class="btn btn-sm btn-primary my-1">
                                <i class="fa fa-eye mr-1"></i>
                                Lihat
                            </a>

                            @if ($domisili->pengajuan->status != 0)
                                <a href="{{ route('admin-domisili-pdf', $domisili->id) }}" class="btn btn-sm btn-secondary my-1" target="_blank" rel="noopener noreferer">
                                    <i class="fa fa-file mr-1"></i>
                                    Cetak PDF
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection