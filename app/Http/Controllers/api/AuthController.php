<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * REGISTER
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Register berhasil',
            'data' => [
                'user' => $user,
            ]
        ], 201);
    }

    /**
     * LOGIN
     * Inisialisasi dan Update informasi Device
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'             => 'required|email',
            'password'          => 'required|string',
            'device_name'       => 'required|string',
            'device_os'         => 'required|string',
            'device_identifier' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah'],
            ]);
        }

        $user->update([
            'device_name'       => $request->device_name,
            'device_os'         => $request->device_os,
            'device_identifier' => $request->device_identifier,
        ]);
        $user->tokens()->delete();

        $token = $user->createToken(
            $request->device_name
        )->plainTextToken;

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]
        ]);
    }

    /**
     * LOGOUT
     * Revoke token aktif
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Logout berhasil',
        ]);
    }

    /**
     * ME
     * Indentifikasi User
     */
    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $request->user(),
        ]);
    }
}
