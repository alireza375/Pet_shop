<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_categories_id',
        'name'
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }


}
