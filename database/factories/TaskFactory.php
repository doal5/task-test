<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\tasks>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Task::class;
    public function definition(): array
    {
        return [
            'nama' => $this->faker->word(),
            'deskripsi' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['belum selesai', 'selesai']),
            'user_id' => User::factory(), // Jika ingin secara otomatis membuat user terkait
            'gambar' => $this->faker->imageUrl(), // Untuk data gambar dummy
        ];
    }
}
