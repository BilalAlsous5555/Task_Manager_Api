<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // custom admin user 
        User::factory()->create([
            'name' => 'bilal',
            'email' => 'bilal@test',
            'is_admin'=>true
        ]);
        User::factory()->count(10)->create();
    }
}
