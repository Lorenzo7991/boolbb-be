<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Appartment;

class Sponsorship extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'price',
        'duration',
        'longitude'
    ];

    /**
     * Define the relationship with the Appartment model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function appartments()
    {
        return $this->belongsToMany(Appartment::class, 'appartaments_sponsorships');
    }
}

