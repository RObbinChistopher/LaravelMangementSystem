<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    public function milestones()
    {
        return $this->belongsTo(Milestones::class, 'milestoneId');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
