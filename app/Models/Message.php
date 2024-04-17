<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'text',
        'name',
        'last_name',
        'email'
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
