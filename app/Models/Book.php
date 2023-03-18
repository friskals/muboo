<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'is_published',
        'released_date',    
        'category_id'
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }
}
