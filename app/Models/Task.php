<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'task';
    public $timestamps = false;
    public $primaryKey = 'task_id';

    protected $fillable = [
        'name', 'description', 'due_date', 'proj_id', 'user_id', 'priority', 'status',
    ];

    protected $attributes = [
        'status' => 'To-do', 
    ];


    public function project(){
        return $this->belongsTo(Project::class, 'proj_id');
    }

    public function assignedMember(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'task_id');
      }

    
  public function getParentComments()
  {
    $parent_comments = array();
    $comments = $this->comments;
    foreach ($comments as $comment)
    {
      if ($comment->parent == null) {
        array_push($parent_comments, $comment);
      }
    }
    return $parent_comments;
  }
}