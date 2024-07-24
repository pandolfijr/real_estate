<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/home');
        }

        return back()->withErrors(['email' => ' * Credenciais inválidas', 'password' => '* Verifique sua senha']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin');
    }
}
