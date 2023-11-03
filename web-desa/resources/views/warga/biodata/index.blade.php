@extends('layouts.main')
@section('content')

<div class="container mt-5">
    <div class="d-flex justify-content-between mb-2 mt-2">
    <h2 class="mb-4">Biodata Anda</h2>
        <a href="{{ route('biodata-edit', ['id' => $biodata->id]) }}" type="button" class="btn btn-success mb-4">
            Ubah Biodata
        </a>
    </div>
    <table class="table">
        <tbody>
            <tr>
                <th>NIK</th>
                <td>{{ $biodata->user->NIK }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $biodata->user->name }}</td>
            </tr>
            <tr>
                <th>Tempat Lahir</th>
                <td>{{$biodata->tempat_lahir}}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $biodata->tanggal_lahir }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{  Str::ucfirst($biodata->jenis_kelamin) }}</td>
            </tr>
            <tr>
                <th>Kebangsaan</th>
                <td>{{ $biodata->Kebangsaan }}</td>
            </tr>
            <tr>
                <th>Pekerjaan</th>
                <td>{{ $biodata->pekerjaan}}</td>
            </tr>
            <tr>
                <th>Status Perkawinan</th>
                <td>{{ $biodata->status_perkawinan }}</td>
            </tr>
            <tr>
                <th>Pendidikan</th>
                <td>{{ $biodata->pendidikan }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $biodata->alamat }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
