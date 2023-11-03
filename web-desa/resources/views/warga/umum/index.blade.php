@extends('layouts.main')

@section('content')
<div class="card mb-4 mt-5">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2 mt-2">
            <h3 class="text-secondary"><strong>Surat Pengantar Umum</strong></h3>
            <a href="{{ route('umum-create') }}" type="button" class="btn btn-success mb-4">
                + Ajukan Surat
            </a>
        </div>
        <div class="table-responsive">
            <table id="userTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center">Tanggal Pengajuan</th>
                        <th class="text-center">Keperluan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Catatan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($umums as $umum)
                    <tr>
                        <td class="text-center">{{ $umum->pengajuan->created_at }}</td>
                        <td class="text-center">{{ $umum->tujuan }}</td>
                        {{-- <td class="text-center">{{ status($umum->pengajuan->status) }}</td> --}}
                        @if ($umum->pengajuan->status == 0)
                        <td class="text-center"><span class="badge badge-secondary">Waiting</span></td>
                        @elseif($umum->pengajuan->status == 1)
                        <td class="text-center"><span class="badge badge-primary">Approve</span></td>
                        @elseif($umum->pengajuan->status == 2)
                        <td class="text-center"><span class="badge badge-danger">Reject</span></td>
                        @elseif($umum->pengajuan->status == 3)
                        <td class="text-center"><span class="badge badge-warning">Revisi</span></td>
                        @endif 
                        <td class="text-center">
                            @php
                                $latestLog = $umum->pengajuan->logs()->latest()->first();
                            @endphp
                            {{ $latestLog && $latestLog->catatan ? $latestLog->catatan : '-' }}
                        </td>
                        <td class="text-center">
                            @if ($umum->pengajuan->status == 0)
                                <a href="{{ route('umum-edit', $umum->id) }}" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-pencil-alt mr-1"></i>
                                    Edit
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