<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Appartment;


class Messages extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'text',
        'name',
        'lastname',
        'email'
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
     * Define the relationship with the Appartment model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appartments()
    {
        return $this->belongsTo(Appartment::class);
    }
}
