<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $admin = Admin::where('email', $request->email)->first();

    if ($admin) {
        \Log::info("Admin ditemukan: " . $admin->email);
    } else {
        \Log::warning("Admin TIDAK ditemukan: " . $request->email);
    }

    if ($admin && Hash::check($request->password, $admin->password)) {
        Session::put('admin_id', $admin->id);
        \Log::info("Login berhasil, redirect ke dashboard");
        return redirect()->route('admin.dashboard');
    }

    \Log::warning("Login gagal untuk email: " . $request->email);
    return back()->with('error', 'Email atau password salah');
}


    public function logout()
    {
        Session::forget('admin_id');
        return redirect()->route('admin.login');
    }
}

