<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'about',
        'position',
    ];

    public function user()
    {
        // many-to-one relationship between two models,
        return $this->belongsTo(User::class);
    }
}
