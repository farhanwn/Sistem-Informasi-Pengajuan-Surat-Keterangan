<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Alert;

class biodataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $biodata = Biodata::where('user_id', auth()->user()->id)->first();

        $user = auth()->user();
        if ($biodata == null) {
            $NIK = $user->NIK;
            $name = $user->name;
            $title = "Biodata";
            $compact = compact('NIK', 'name', 'title');
            return view('warga.biodata.create')->with($compact);
        }
        return view('warga.biodata.index', compact('biodata'), [
            "title" =>  "Biodata"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warga.biodata.create', [
            "title" =>  "Biodata"
        ]);
    }

    public function edit($id)
    {
        $biodata = Biodata::find($id);
        $title = "Edit Biodata";
        return view('warga.biodata.edit', compact('biodata', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'Kebangsaan' => 'required',
            'agama' => 'required',
            'status_perkawinan' => 'required',
            'pendidikan' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::info('Warning', 'Validation Error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $biodata = new Biodata();
            $biodata->user_id = auth()->id();
            $biodata->tempat_lahir = $request->tempat_lahir;
            $biodata->tanggal_lahir = $request->tanggal_lahir;
            $biodata->pekerjaan = $request->pekerjaan;
            $biodata->jenis_kelamin = $request->jenis_kelamin;
            $biodata->Kebangsaan = $request->Kebangsaan;
            $biodata->agama = $request->agama;
            $biodata->status_perkawinan = $request->status_perkawinan;
            $biodata->pendidikan = $request->pendidikan;
            $biodata->alamat = $request->alamat;
            $biodata->save();

            Alert::success('Berhasil', 'Berhasil Menambahkan Biodata');
            return redirect(route('biodata-index'));
        } catch (\Throwable $th) {
            return $th;
            Alert::error('Error', 'Gagal Menambahkan');
            return redirect()->back();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'Kebangsaan' => 'required',
            'agama' => 'required',
            'status_perkawinan' => 'required',
            'pendidikan' => 'required',
            'alamat' => 'required',
            'pekerjaan' => 'required', // Assuming 'pekerjaan' is a new field
            // Add other fields as needed
        ]);

        if ($validator->fails()) {
            Alert::info('Warning', 'Validation Error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $biodata = Biodata::find($id);
            $biodata->user_id = auth()->id();
            $biodata->tempat_lahir = $request->tempat_lahir;
            $biodata->tanggal_lahir = $request->tanggal_lahir;
            $biodata->pekerjaan = $request->pekerjaan;
            $biodata->jenis_kelamin = $request->jenis_kelamin;
            $biodata->Kebangsaan = $request->Kebangsaan;
            $biodata->agama = $request->agama;
            $biodata->status_perkawinan = $request->status_perkawinan;
            $biodata->pendidikan = $request->pendidikan;
            $biodata->alamat = $request->alamat;

            $biodata->save();

            Alert::success('Berhasil', 'Berhasil Mengupdate Biodata');
            return redirect(route('biodata-index'));
        } catch (\Throwable $th) {
            Alert::error('Error', 'Gagal Mengupdate');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
