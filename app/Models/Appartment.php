<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Messages;

class Appartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'address',
        'latitude',
        'longitude',
        'title',
        'description',
    ];

    /**
     * Define the relationship with the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the relationship with the Messages model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appartments()
    {
        return $this->hasMany(Messages::class);
    }
}
