<?php

namespace App\Services;

use App\Models\User;
use App\Models\Conta;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUserAndAccount($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $conta = Conta::create([
            'user_id' => $user->id,
            'saldo' => 0,
        ]);

        return $user;
    }
}
