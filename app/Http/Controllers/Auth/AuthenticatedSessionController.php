<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials)) {
            return response(['message' => 'Credenciales no válidas'], 422);
        }

        $user = $request->user();
        $token = $user->createToken('api')->plainTextToken;
        
        // Incluir datos de profesor si el usuario es profesor
        $userData = $user->toArray();
        if ($user->isProfesor() && $user->profesor) {
            $userData['profesor_id'] = $user->profesor->id;
        }
        
        return response([
            'token' => $token,
            'user'  => $userData,
            'role'  => $user->role,
        ], 200);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $request->user()->currentAccessToken()?->delete();
        return response()->noContent();
    }
}
