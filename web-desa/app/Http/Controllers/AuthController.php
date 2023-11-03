<?php

namespace App\Http\Controllers;

use Alert;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('login.login', [
            "title" =>  "Login"
        ]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            Alert::info('Gagal Login', "Username atau password salah !");
            return redirect()->back()->withInput();
        }

        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {

            if (Auth::user()->role === 'admin') {
                return redirect(route('admin-dashboard-index'));
            } else {
                return redirect(route('dashboard-index'));
            }
            

        }

        Alert::info('Gagal Login', "Username atau password salah !");
        return redirect()->back();
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('login-show'));
    }
}
