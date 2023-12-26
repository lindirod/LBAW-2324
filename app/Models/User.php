<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Added to define Eloquent relationships.
use App\Models\Project;
use App\Models\Company;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;

    protected $table = 'users';
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    public $primaryKey  = 'user_id';


    protected $fillable = [
        'name', 'username', 'email', 'password', 'is_admin', 'profile_image'
    ];

    protected $attributes = [
        'projects_completed' => 0,
        'projects_in_progress' => 0,
        'tasks_completed' => 0,
        'tasks_in_progress' => 0,
    ];    

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function coordinates(){
        return $this->hasMany(Project::class, 'coord_id');
    }
    
    public function companies(){
        return $this->belongsToMany(Company::class,'employee','user_id','comp_id');
    }
    
    public function projects(){
        return $this->belongsToMany(Project::class, 'project_member', 'user_id', 'proj_id');
    }
    public function favorites(){
        return $this->belongsToMany(Project::class, 'favorite', 'owner_id', 'proj_id');
    }
    public function archived(){
        return $this->belongsToMany(Project::class, 'archive', 'author_id', 'proj_id');
    }
    public function invitations(){
        return $this->belongsToMany(Project::class,'invitation','user_id','proj_id');
    }

    public function assigned(){
        return $this->hasMany(Task::class, 'user_id');
    }

    public function isFavorite(Project $project){
        $favs=$this->favorites;
        foreach($favs as $fav){
            if($fav->proj_id==$project->proj_id)
                return TRUE;
        }
        return FALSE;
    }

    public function isArchived(Project $project){
        $archs=$this->archived;
        foreach($archs as $arch){
            if($arch->proj_id==$project->proj_id)
                return TRUE;
        }
        return FALSE;
    }

    public function comments()
{
    return $this->hasMany(Comment::class, 'assigned_member');
}

}
