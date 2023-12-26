<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentNotification extends Model
{
    protected $table = 'assignment_notification';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false; 
    protected $fillable = ['task_id', 'notif_id'];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notif_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
