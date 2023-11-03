@extends('layouts.main')
@section('content')
<div class="card shadow mb-4 mt-5">
    <div class="card-body">
        <h3 class="font-weight-bold text-secondary mb-2 mt-2"><strong>Tambah Biodata</strong></h3>
        <form class="p-3" method="POST" action="{{ route('biodata-store') }}">
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="NIK">NIK</label>
                    <input type="text" class="form-control" id="NIK" name="NIK" value="{{ $NIK }}" required>
                </div>
                <div class="col-md-6">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $name }}" required>
                </div>
                <div class="col-md-6">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                </div>
                <div class="col-md-6">
                    <label for="tempat_lahir">Pekerjaan</label>
                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" required>
                </div>
                <div class="col-md-6">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                </div>
                <div class="col-md-6">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="laki-Laki">Laki-Laki </option>
                        <option value="Perempuan">Perempuan </option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="Kebangsaan">Kebangsaan</label>
                    <input type="Text" class="form-control" id="Kebangsaan" name="Kebangsaan" required>
                </div>
                <div class="col-md-6">
                    <label for="agama">Agama</label>
                    <select class="form-control" id="agama" name="agama" required>
                        <option value="Islam">Islam </option>
                        <option value="Protestan">Protestan</option>
                        <option value="Katolik">Katolik </option>
                        <option value="Budha">Budha </option>
                        <option value="Hindu">Hindu </option>
                        <option value="Konghuchu">Konghuchu </option>
                        <option value="Lainnya">Lainnya </option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="status_perkawinan">Status Perkawinan</label>
                    <select class="form-control" id="status_perkawinan" name="status_perkawinan" required>
                        <option value="Menikah">Menikah </option>
                        <option value="Belum Menikah">Belum Menikah </option>
                        <option value="Bercerai">Bercerai </option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="pendidikan">Pendidikan</label>
                    <select class="form-control" id="pendidikan" name="pendidikan" required>
                        <option value="SD">SD </option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA </option>
                        <option value="D3">D3 </option>
                        <option value="S1">S1 </option>
                        <option value="S2">S2 </option>
                        <option value="S3">S3 </option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>
            </div>
            <button type="submit" class="btn btn-secondary mt-3">Submit</button>
        </form>

    </div>
</div>
@endsection
