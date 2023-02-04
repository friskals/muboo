<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Book\StoreRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function store(StoreRequest $request){  
        $image = $request->file('image');

        Book::create([
            'title' => $request->title,
            'author_id' => $request->author_id,
            'author_name' => $request->author_name,
            'is_published' => $request->is_published,
            'image' => $image->storeAs(
                'images',
                $image->getClientOriginalName(),
                'public'
            )
        ]);
        
        return "ok";
    }
}
