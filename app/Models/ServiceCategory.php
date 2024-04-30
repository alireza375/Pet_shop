<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    public function Services()
    {
        // Indicates a one-to-many relationship.
        return $this->hasMany(Service::class);
    }
    public function SubCate()
    {
        // Indicates a one-to-many relationship.
        return $this->hasMany(Sub_Category::class);
    }
}
