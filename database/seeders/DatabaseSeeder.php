<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Task;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    $this->call(
            [
                UserSeeder::class,
                StatusSeeder::class,
                TaskSeeder::class,
                CommentSeeder::class
            ]
            );
    }
}
