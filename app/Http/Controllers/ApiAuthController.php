<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class ApiAuthController extends Controller
{
    // Registre d'usuari
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Usuari registrat correctament!',
            'token' => $user->createToken('API Token')->plainTextToken,
            'user' => $user
        ], 201);
    }

    // Login d'usuari
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Les credencials no són correctes.'],
            ]);
        }

        return response()->json([
            'message' => 'Login correcte!',
            'token' => $user->createToken('API Token')->plainTextToken,
            'user' => $user
        ]);
    }

    // Logout d'usuari
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Sessió tancada correctament'
        ]);
    }
}
