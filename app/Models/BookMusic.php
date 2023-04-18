<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookMusic extends Model
{
    use HasFactory;

    protected $table = 'musics';

    protected $fillable = [
        'book_id',
        'external_music_id',
        'title',
        'fans'
    ];
}
