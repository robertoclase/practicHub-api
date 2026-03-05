<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Comprobar si el correo existe
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response([
                'message' => 'No existe ninguna cuenta con ese correo electrónico.',
                'field'   => 'email',
            ], 422);
        }

        // Comprobar contraseña
        if (! Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'La contraseña introducida es incorrecta.',
                'field'   => 'password',
            ], 422);
        }

        // Autenticación OK
        Auth::login($user);
        $token = $user->createToken('api')->plainTextToken;

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
