<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;
    protected $fillable = [
        'address',
        'latitude',
        'longitude',
        'title',
        'description',
        'rooms',
        'beds',
        'bathrooms',
        'square_meters',
        'image',
        'is_visible'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function sponsorships()
    {
        return $this->belongsToMany(Message::class);
    }
}
