<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Task;
use App\Models\tasks;
use App\Models\User;
use Database\Factories\TaskFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory()->count(10)->create();

        // Untuk setiap pengguna, buat 5 tugas
        foreach ($users as $user) {
            Task::factory()->count(5)->create(['user_id' => $user->id]);
        }
    }
}
