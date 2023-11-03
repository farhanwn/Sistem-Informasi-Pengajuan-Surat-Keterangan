<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Alert;

class registerController extends Controller
{
    public function index()
    {
        return view('login.register', [
            "title" =>  "Register"
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NIK' => 'required|unique:users,NIK',
            'name' => 'required|string|min:5',
            'username' => 'required|string|min:4|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ], [
            'NIK.unique' => 'NIK telah digunakan.',
            'username.unique' => 'Username telah digunakan.',
            'email.unique' => 'Email telah digunakan.'
        ]);

        if ($validator->fails()) {
            Alert::info('Warning', 'Validation Error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            User::create([
                'NIK' => $request->NIK,
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'role' => 'warga',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make($request->password),
            ]);

            Alert::success('Berhasil', 'Berhasil Membuat Akun');
            return redirect(route('login-show'));
        } catch (\Throwable $th) {
            dd($th->getMessage()); // Tampilkan pesan error untuk debugging
            Alert::error('Error', 'Registrasi Gagal');
            return redirect()->back();
        }
    }
}
