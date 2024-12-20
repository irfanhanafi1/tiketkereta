<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   // Login
   public function login(Request $request)
   {
       $validated = $request->validate([
           'email' => 'required|email',
           'password' => 'required'
       ]);

       $user = User::where('email', $validated['email'])->first();

       if (!$user || !Hash::check($validated['password'], $user->password)) {
           return response()->json(['message' => 'Login gagal. Kredensial salah.'], 401);
       }

       // Buat token untuk user
       $token = $user->createToken('user-token')->plainTextToken;

       return response()->json([
           'message' => 'Login berhasil',
           'user' => $user,
           'token' => $token
       ]);
   }

   // Register
   public function register(Request $request)
   {
       $validated = $request->validate([
           'name' => 'required|interger',
           'email' => 'required|email|unique:users,email',
           'password' => 'required|min:8'
       ]);

       $user = User::create([
           'name' => $validated['name'],
           'email' => $validated['email'],
           'password' => bcrypt($validated['password']),
       ]);

       $token = $user->createToken('user-token')->plainTextToken;

       return response()->json([
           'message' => 'Registrasi berhasil',
           'user' => $user,
           'token' => $token
       ]);
   }

   // Logout
   public function logout(Request $request)
   {
       $request->user()->tokens()->delete();

       return response()->json(['message' => 'Logout berhasil']);
   }
}
