<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comment';
    public $timestamps = false;
    protected $primaryKey = 'comment_id';

    protected $fillable = [
        'date', 'content', 'task_id', 'assigned_member', 'reply',
    ];

    public function task(){
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function author(){
        return $this->belongsTo(User::class, 'assigned_member');
    }

    public function replies(){
        return $this->hasMany(Comment::class, 'reply');
    }

    public function parent()
    {
    return $this->belongsTo(Comment::class, 'id');
    }

}