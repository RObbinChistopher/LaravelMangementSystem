<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject',
        'user_id',
        'message',
        'status',
    ];

    public function user (){
        return $this->belongsTo(User::class, 'user_id');
    }
}
