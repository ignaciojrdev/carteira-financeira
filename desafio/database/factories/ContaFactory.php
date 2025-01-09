<?php

namespace Database\Factories;

use App\Models\Conta;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContaFactory extends Factory
{
    protected $model = Conta::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'saldo' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
