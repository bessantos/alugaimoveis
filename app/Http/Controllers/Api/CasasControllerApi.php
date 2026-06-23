<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Casa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CasasControllerApi extends Controller
{
    public function index()
    {
        $casas = Casa::with('user:id,name')->get();
        return response()->json([
            'success' => true,
            'message' => 'Lista de casas',
            'data'    => $casas
        ]);
    }

    public function show($id)
    {
        $casa = Casa::with('user:id,name')->find($id);

        if (!$casa) {
            return response()->json(['success' => false, 'message' => 'Casa não encontrada'], 404);
        }

        return response()->json(['success' => true, 'data' => $casa]);
    }

    public function loginapi(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais são inválidas.']
            ]);
        }

        return response()->json([
            'success' => true,
            'token'   => $user->createToken('api-token')->plainTextToken
        ]);
    }
}