<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'nip' => $this->faker->unique()->numerify('##########'),
            'password' => bcrypt('password123'),
            'nama_pengguna' => $this->faker->userName,
            'posisi' => $this->faker->word,
            'tugas' => $this->faker->sentence,
            'foto' => $this->faker->imageUrl(),
            'role' => 'Admin',
        ];
    }
}
