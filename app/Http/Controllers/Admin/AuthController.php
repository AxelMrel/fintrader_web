<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email ou mot de passe incorrect.',
            ])->withInput();
        }

        // Vérifier que c'est bien un admin
        if (!Auth::user()->isAdmin()) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Accès refusé. Réservé aux administrateurs.',
            ]);
        }

        // Vérifier que le compte est actif
        if (!Auth::user()->is_active) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Votre compte a été désactivé.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}