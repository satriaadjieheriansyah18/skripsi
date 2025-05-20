<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Baca request dalam format JSON
        $data = $request->json()->all(); 

        // Validasi request
        $validator = \Validator::make($data, [
            'phone_number' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Simpan user baru ke database
        $user = \App\Models\User::create([
            'phone_number' => $data['phone_number'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => [
                'phone_number' => $user->phone_number,
                'username' => $user->username, // Pastikan hanya kirim data yang diperlukan
                'email' => $user->email
            ]
        ], 201);
    }
    
    public function login(Request $request)
{
    // Pastikan request dikirim dalam format JSON
    $data = json_decode($request->getContent(), true);

    if (!$data) {
        return response()->json(['message' => 'Invalid JSON request'], 400);
    }

    // Validasi input
    $validator = \Validator::make($data, [
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors' => $validator->errors(),
        ], 422);
    }

    // Cek apakah user ada di database
    $user = \App\Models\User::where('email', $data['email'])->first();

    if (!$user || !\Hash::check($data['password'], $user->password)) {
        return response()->json([
            'message' => 'Email atau password salah'
        ], 401);
    }

    // Buat token untuk autentikasi
    $token = $user->createToken('authToken')->plainTextToken;

    return response()->json([
        'message' => 'Login berhasil',
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'phone_number' => $user->phone_number,  // Pastikan mengirim username
            'username' => $user->username,  // Pastikan mengirim username
            'email' => $user->email,
        ]
    ], 200);
}



}
