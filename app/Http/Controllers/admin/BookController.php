<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Book\StoreRequest;
use App\Http\Requests\Admin\Book\UpdateRequest;
use App\Models\Book;

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

    public function update(UpdateRequest $request, $id){
        $book = Book::findOrFail($id);
        
        $updated = $request->all();

        unset($updated['image']);

        $book->update($updated);
        
        return "ok";
    }
}
