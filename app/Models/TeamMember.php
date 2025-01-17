<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = 'team_members';
    use HasFactory;


    public function users(){
        return $this->belongsTo(User::class, 'member_id');
    }
    public function team(){
        return $this->belongsTo(Teams::class, 'team_id');
    }
    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }
}
