<?php

namespace App\Http\Controllers;


use App\Models\User; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;




class AuthController extends Controller
{

    //metodo de registo
   
    
    public function register(Request $request)
    {
        try {
            // Validação dos dados
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed', // Aumentei para min 8 caracteres
            ]);
    
            // Criação do usuário
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);
    
            // Geração do token de acesso (requer Sanctum)
            $token = $user->createToken('auth_token')->plainTextToken;
    
            // Resposta com token
            return response()->json([
                'message' => 'Usuário registrado com sucesso!',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 201);
    
        } catch (\Exception $e) {
            // Tratamento de erros
            return response()->json([
                'message' => 'Erro no registro',
                'error' => $e->getMessage()
            ], 500);
        }
    }






    // método de login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciais inválidas'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }







}
