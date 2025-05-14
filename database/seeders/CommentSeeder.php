<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('is_admin',false)->get();
        $tasks = Task::all();
        Comment::factory()->count(40)->make()->each(function ($comment) use($users,$tasks){
            $comment->user_id = $users->random()->id;
            $comment->task_id = $tasks->random()->id;
            $comment->save();
        });
    }
}
