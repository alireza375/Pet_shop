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
        'price',
        'image',
        'category_id',
        'address'
    ];

    public function category()
    {
        // Indicates a many-to-one relationship.
        return $this->belongsTo(ServiceCategory::class);
    }
}
