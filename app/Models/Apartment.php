<?php

namespace App\Models;

//use Attribute;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Apartment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'address',
        'latitude',
        'longitude',
        'title',
        'description',
        'rooms',
        'beds',
        'bathrooms',
        'square_meters',
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

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => [
                'title' => $value,
                'slug' => Str::slug($value)
            ]
        );
    }

    public function getFormattedDate($column, $format = 'd-m-Y')
    {

        return Carbon::create($this->$column)->format($format);
    }
}
