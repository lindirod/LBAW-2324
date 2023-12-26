<?php

// app/Models/ProjectNotification.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectNotification extends Model
{
    protected $table = 'project_notification';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false; 
    protected $fillable = ['proj_id', 'notif_id'];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notif_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'proj_id');
    }
}

