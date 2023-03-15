<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Book\StoreRequest;
use App\Http\Requests\Admin\Book\UpdateRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        return view('admin.book.index')->with('books', collect([]));
    }

    public function store(StoreRequest $request)
    {
        $image = $request->file('image');

        $author = Author::findOrfail($request->author_id);

        $book = Book::create([
            'title' => $request->title,
            'is_published' => $request->is_published,
            'image' => $image->storeAs(
                'images',
                $image->getClientOriginalName(),
                'public'
            ),
            'released_at' => $request->released_at
        ]);

        BookAuthor::create([
            'book_id' => $book->id,
            'book_title' => $book->title,
            'author_id' => $author->id,
            'author_name' => $author->name,
            'is_published' => $book->is_published,
            'image' => $book->image
        ]);

        return "ok";
    }

    public function update(UpdateRequest $request, $id)
    {
        $book = Book::findOrFail($id);

        $updated = $request->all();

        if ($image = $request->file('image')) {

            $updated['image'] = $image->storeAs(
                'images',
                $image->getClientOriginalName(),
                'public'
            );

            Storage::disk('public')->delete($book->image);
        }

        $book->update($updated);

        return "ok";
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        Storage::disk('public')->delete($book->image);

        $book->delete();

        return "ok";
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);

        return $book;
    }
}
