<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'short_description',
        'category_id',
        'price',
        'image',

        'address'
    ];

    public function category()
    {
        // Indicates a many-to-one relationship.
        return $this->belongsTo(ServiceCategory::class);
    }
}
