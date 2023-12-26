<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';
    public $timestamps = false;
    public $primaryKey = 'comp_id';

    protected $fillable = [
        'name', 'admin_id'
    ];

    
    public function administrator(){
        return $this->belongsTo(Administrator::class, 'admin_id');
    }


    public function workers(){
        return $this->belongsToMany(User::class,'employee','comp_id','user_id');
    }


    public function projects(){
        return $this->hasMany(Project::class, 'comp_id');
    }

    public function works($user_id){
        foreach($this->workers as $worker){
            if($worker->id==$user_id){
                return TRUE;
            }
        }
        return FALSE;
    }
}
