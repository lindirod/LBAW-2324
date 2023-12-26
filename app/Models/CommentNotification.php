<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentNotification extends Model
{
    protected $table = 'comment_notification';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false; 
    protected $fillable = ['comment_id', 'notif_id'];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notif_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}

