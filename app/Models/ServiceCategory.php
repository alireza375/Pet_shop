<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function Services()
    {
        // Indicates a one-to-many relationship.
        return $this->hasMany(Service::class);
    }
}
