<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $tasks = Task::all()->shuffle();
        // Status::factory()->count(10)->make()->each(function ($status,$index) use($tasks){
        //     $status->task_id = $tasks[$index]->id; // Assign a unique task_id
        //     $status->save();
        // });
        Status::factory()->count(10)->create();
    }
}
