<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    // Accessor per ottenere il path assoluto delle immagini solo in chiamate api
    public function path(): Attribute
    {
        return Attribute::make(fn ($value) => $value
            && app('request')->is('api/*')
            ? url('storage/' . $value) : $value);
    }
}
