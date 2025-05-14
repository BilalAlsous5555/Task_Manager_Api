<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Task extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'task_content',
        'priority' , 
        'user_id' ,
        'status_id' ,
    ];
    protected $hidden =
    [
        'created_at',
        'updated_at' , 
    ];
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
