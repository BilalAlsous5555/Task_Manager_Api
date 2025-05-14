<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('is_admin',false)->get();
        $statuses = Status::all();
        Task::factory()->count(50)->make()->each(function($task) use($users,$statuses){
            $task->user_id = $users->random()->id;
            $task->status_id = $statuses->random()->id;
            $task->save();
        });
    }
}
