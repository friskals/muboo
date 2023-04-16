<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Content;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function show($id)
    {
        $book = Book::findOrFail($id);

        $reviews = Content::where([
            'book_id' => $book->id,
            'type' => 'REVIEW'
        ])->limit(5)->get();

        return response()->json([
            'success' => true,
            'book' => $book,
            'reviews' => $reviews
        ]);
    }
}
