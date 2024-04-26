<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'origin',
        'year_recognized',
        'description',
        'traits',
        'specifications',
        'image',
    ];

    protected $casts = [
        'traits' => 'array',
        'specifications' => 'array',
    ];



}
