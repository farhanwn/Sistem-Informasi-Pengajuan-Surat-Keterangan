@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col mb-4">

        @if ($domisili->pengajuan->status == 0)
            <form action="{{ route('admin-domisili-approve', $domisili->pengajuan_id) }}" method="post" class="d-inline-block">
                @csrf
                <button type="submit" class="btn btn-success mr-2">
                    <i class="fa fa-check mr-1"></i>
                    Approve
                </button>
            </form>

            <form action="{{ route('admin-domisili-reject', $domisili->pengajuan_id) }}" method="post" class="d-inline-block">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-times mr-1"></i>
                    Reject
                </button>
            </form>
            <form action="{{ route('admin-domisili-revisi', $domisili->pengajuan_id) }}" method="post" class="d-inline-block">
                @csrf
                <button type="submit" class="btn btn-warning">
                    <i class="fa fa-times mr-1"></i>
                    Revisi
                </button>
            </form>
        @else
             <a href="{{ route('admin-domisili-pdf', $domisili->id) }}" class="btn btn-sm btn-secondary my-1" target="_blank" rel="noopener noreferer">
                <i class="fa fa-file mr-1"></i>
                Cetak PDF
            </a>
        @endif

    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0">Data Diri yang Mengajukan</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" class="form-control" id="nik" disabled value="{{ $biodata->user->NIK }}">
                </div>

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" disabled value="{{ $biodata->user->name }}">
                </div>

                <div class="form-group">
                    <label for="tempat-lahir">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat-lahir" disabled value="{{ $biodata->tempat_lahir }}">
                </div>

                <div class="form-group">
                    <label for="tanggal-lahir">Tanggal Lahir</label>
                    <input type="text" class="form-control" id="tanggal-lahir" disabled value="{{ $biodata->tanggal_lahir }}">
                </div>

                <div class="form-group">
                    <label for="jk">Jenis Kelamin</label>
                    <input type="text" class="form-control" id="jk" disabled value="{{ Str::ucfirst($biodata->jenis_kelamin) }}">
                </div>

                <div class="form-group">
                    <label for="kebangsaan">Kebangsaan</label>
                    <input type="text" class="form-control" id="kebangsaan" disabled value="{{ Str::ucfirst($biodata->Kebangsaan) }}">
                </div>

                <div class="form-group">
                    <label for="status-perkawinan">Status Perkawinan</label>
                    <input type="text" class="form-control" id="status-perkawinan" disabled value="{{ $biodata->status_perkawinan }}">
                </div>

                <div class="form-group">
                    <label for="pendidikan">Pendidikan</label>
                    <input type="text" class="form-control" id="pendidikan" disabled value="{{ $biodata->pendidikan }}">
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea rows="3" class="form-control" id="alamat" disabled>{{ $biodata->alamat }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="m-0">Data Tambahan</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="domisili">Domisili</label>
                    <textarea type="text" class="form-control" id="domisili" disabled>{{ $domisili->domisili }}</textarea>
                </div>

                <div class="form-group">
                    <label for="keperluan">Keperluan <span class="text-danger">*</span></label>
                    <textarea type="text" class="form-control" id="keperluan"  disabled>{{ $domisili->tujuan }}</textarea>
                </div>

                <div class="form-group">
                    <label class="d-block">Scan KTP</label>
                    @if ($domisili->pengajuan->scan_ktp)
                        <a href="{{ asset('storage/'.$domisili->pengajuan->scan_ktp) }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener noreferer">
                            Lihat KTP
                        </a>
                    @else
                        <i>Tidak ada KTP</i>
                    @endif
                </div>

                <div class="form-group">
                    <label class="d-block">Scan KK</label>
                    @if ($domisili->pengajuan->scan_kk)
                        <a href="{{ asset('storage/'.$domisili->pengajuan->scan_kk) }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener noreferer">
                            Lihat KK
                        </a>
                    @else
                        <i>Tidak ada KK</i>
                    @endif
                </div>

                <div class="form-group">
                    <label class="d-block">Scan AKta Kelahiran</label>
                    @if ($domisili->pengajuan->scan_akta)
                        <a href="{{ asset('storage/'.$domisili->pengajuan->scan_akta) }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener noreferer">
                            Lihat Akta Kelahiran
                        </a>
                    @else
                        <i>Tidak ada Akta Kelahiran</i>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin-domisili-comment', $domisili->pengajuan_id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="catatan">Catatan untuk yang mengajukan</label>
                        <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Mis. melengkapi berkas atau memperbaiki data"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Tambah catatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0">Log Pengajuan</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Penanggung Jawab</th>
                                <th class="text-center">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                            <tr>
                                <td>{{ $loop->iteration.'.' }}</td>
                                <td class="text-center">{{ $log->created_at }}</td>
                                <td class="text-center">{{ status($log->status) }}</td>
                                <td class="text-center">{{ $log->user->name }}</td>
                                <td>
                                    {{ $log->catatan ?? '-' }}
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