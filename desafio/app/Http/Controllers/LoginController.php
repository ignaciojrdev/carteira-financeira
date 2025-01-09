<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('Login');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended('/Conta');
        }

        return back()->withErrors([
            'email' => 'As credenciais informadas não são válidas.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}