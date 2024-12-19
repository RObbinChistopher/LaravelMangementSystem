<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    // Add these attributes to the fillable array
    protected $fillable = [
        'email',
        'subject',
        'message',
        'userId',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
