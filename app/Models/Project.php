<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'project';
    public $timestamps = false;
    public $primaryKey = 'proj_id';

    protected $fillable = [
        'name', 'description', 'due_date', 'comp_id', 'coord_id', 'percentageCompleted'
    ];
    
    public function tasks(){
        return $this->hasMany(Task::class, 'proj_id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'comp_id');
    }

    public function coordinator(){
        return $this->belongsTo(User::class, 'coord_id');
    }

    public function member(){
        return $this->belongsToMany(User::class,'project_member', 'proj_id', 'user_id');
    }
    public function fav_owner(){
        return $this->belongsToMany(User::class,'favorite', 'proj_id', 'owner_id');
    }

    public function arch_owner(){
        return $this->belongsToMany(User::class,'archive', 'proj_id', 'author_id');
    }
  public function membersInvited(){
        return $this->belongsToMany('App\Models\User','invitation','proj_id','user_id');
    }
    public function getPercentageCompleted(){
      if (count($this->tasks) > 0)
        return intdiv(count($this->tasks->where('status', 'Completed')) * 100, count($this->tasks));
      else return 0;
    }
    public function isMember($userId){
       return $this->member->contains('user_id', $userId);
    }
  
    
}

