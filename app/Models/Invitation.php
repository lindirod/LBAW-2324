<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table='invitation';
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'proj_id');
    }
}