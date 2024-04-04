<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {   
        // dd($request);
        // Valider les données du formulaire
        // Log::info('Données reçues : ' . json_encode($request->all()));
        $request->validate([
            'code' => 'required|string',
            'password' => 'required|string',
        ]);

        // connecter l'utilisateur avec les champs code et mot de passe
        if (Auth::attempt(['code' => $request->code, 'password' => $request->password])) {
            // Si l'authentification réussit, rediriger vers le tableau de bord
            return redirect()->intended('/dashboard');
        } else {
            // Si l'authentification échoue, rediriger vers le formulaire de connexion avec un message d'erreur
            return redirect()->back()->withInput($request->only('code'))->withErrors([
                'code' => 'Les informations d\'identification sont incorrectes',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return view('auth.login');
    }
}
