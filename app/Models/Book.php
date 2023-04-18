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
        'category_id',
        'excerpts'
    ];

    protected $append = ['short_title'];

    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }

    public function getStatusAttribute()
    {
        return $this->is_published  == 1 ? "Published" : "Unpublished";
    }

    public function getShortTitleAttribute()
    {
        return strlen($this->title) > 30 ? substr($this->title, 0, 25) . '. . . .' : $this->title;
    }
}
