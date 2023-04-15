<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
        'status'
    ];

    public function scopeIsActive($query)
    {
        return $query->where('status','Active');
    }

    public function isActive(){
        return $this->status == 'Active';
    }
}
