@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0">Data diri</h3>
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

                <div class="form-group mt-4 mb-0">
                    <a href="{{ route('biodata-edit', $biodata->id ) }}" class="btn btn-secondary">
                        <i class="fa fa-pencil-alt mr-1"></i>
                        Edit Biodata
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0">Data Tambahan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('domisili-update', $domisili->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="domisili">Domisili <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="domisili" name="domisili" required>{{ old('domisili', $domisili->domisili) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="keperluan">Keperluan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="keperluan" name="tujuan" required>{{ old('tujuan', $domisili->tujuan) }}</textarea>
                    </div>

                    {{-- <div class="form-group">
                        <label for="ktp">Scan KTP <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="ktp" id="ktp" class="custom-file-input" placeholder="Pilih berkas">
                                <label for="ktp" class="custom-file-label">Pilih berkas</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="akta-kelahiran">Scan Akta Kelahiran <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="akta-kelahiran" id="akta-kelahiran" class="custom-file-input" placeholder="Pilih berkas">
                                <label for="akta-kelahiran" class="custom-file-label">Pilih berkas</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="kk">Scan KK <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="kk" id="kk" class="custom-file-input" placeholder="Pilih berkas">
                                <label for="kk" class="custom-file-label">Pilih berkas</label>
                            </div>
                        </div>
                    </div> --}}

                    <div class="form-group">
                        <label for="ktp">Scan KTP</label>
                        <input type="file" name="ktp" id="ktp" class="form-control" placeholder="Pilih Berkas">
                    </div>

                    <div class="form-group">
                        <label for="kk">Scan KK</label>
                        <input type="file" name="kk" id="kk" class="form-control" placeholder="Pilih Berkas">
                    </div>

                    <div class="form-group">
                        <label for="akta-kelahiran">Scan Akta Kelahiran</label>
                        <input type="file" name="akta-kelahiran" id="akta-kelahiran" class="form-control" placeholder="Pilih Berkas">
                    </div>

                    <div class="form-group mt-4 mb-0">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-paper-plane mr-1"></i>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection