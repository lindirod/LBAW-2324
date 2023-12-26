<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';
    protected $primaryKey = 'notif_id';
    public $timestamps = false; 
    protected $fillable = ['date', 'content'];

    public function projectNotifications()
    {
        return $this->hasMany(ProjectNotification::class, 'notif_id');
    }

    public function assignmentNotifications()
    {
        return $this->hasMany(AssignmentNotification::class, 'notif_id');
    }

    public function commentNotifications()
    {
        return $this->hasMany(CommentNotification::class, 'notif_id');
    }
}

