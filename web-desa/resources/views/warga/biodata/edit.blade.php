@extends('layouts.main')
@section('content')
    <div class="card shadow mb-4 mt-5">
        <div class="card-body">
            <h3 class="font-weight-bold text-secondary mb-2 mt-2"><strong>Edit Biodata</strong></h3>
            <form class="p-3" method="POST" action="{{ route('biodata-update', $biodata->id) }}">
                @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ $biodata->tempat_lahir }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $biodata->tanggal_lahir }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="laki-Laki" {{ $biodata->jenis_kelamin == 'laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="Perempuan" {{ $biodata->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="Kebangsaan">Kebangsaan</label>
                        <input type="text" class="form-control" id="Kebangsaan" name="Kebangsaan" value="{{ $biodata->Kebangsaan }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="agama">Agama</label>
                        <select class="form-control" id="agama" name="agama" required>
                            <option value="Islam" {{ $biodata->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Protestan" {{ $biodata->agama == 'Protestan' ? 'selected' : '' }}>Protestan</option>
                            <option value="Katolik" {{ $biodata->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Budha" {{ $biodata->agama == 'Budha' ? 'selected' : '' }}>Budha</option>
                            <option value="Hindu" {{ $biodata->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Konghuchu" {{ $biodata->agama == 'Konghuchu' ? 'selected' : '' }}>Konghuchu</option>
                            <option value="Lainnya" {{ $biodata->agama == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="status_perkawinan">Status Perkawinan</label>
                        <select class="form-control" id="status_perkawinan" name="status_perkawinan" required>
                            <option value="Menikah" {{ $biodata->status_perkawinan == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                            <option value="Belum Menikah" {{ $biodata->status_perkawinan == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="Bercerai" {{ $biodata->status_perkawinan == 'Bercerai' ? 'selected' : '' }}>Bercerai</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="pendidikan">Pendidikan</label>
                        <select class="form-control" id="pendidikan" name="pendidikan" required>
                            <option value="SD" {{ $biodata->pendidikan == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ $biodata->pendidikan == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ $biodata->pendidikan == 'SMA' ? 'selected' : '' }}>SMA</option>
                            <option value="D3" {{ $biodata->pendidikan == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ $biodata->pendidikan == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ $biodata->pendidikan == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ $biodata->pendidikan == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ $biodata->pekerjaan }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $biodata->alamat }}" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary mt-3">Update</button>
            </form>
        </div>
    </div>
@endsection
