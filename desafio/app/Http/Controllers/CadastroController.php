<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class CadastroController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('Cadastro');
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->userService->createUserAndAccount($request->validated());

        Auth::login($user);

        return redirect()->route('home');
    }
}