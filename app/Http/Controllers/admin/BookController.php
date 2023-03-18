<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Book\FilterRequest;
use App\Http\Requests\Admin\Book\StoreRequest;
use App\Http\Requests\Admin\Book\UpdateRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    const TOTAL_DEFAULT_ITEM = 15;

    public function index()
    {
        return view('admin.book.index')->with('books', collect([]));
    }

    public function create()
    {
        $authors = Author::select('id', 'name')->get();

        $categories = Category::select('id', 'name')->isActive()->get();

        return view('admin.book.create')->with([
            'authors' => $authors,
            'categories' => $categories
        ]);
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
            'released_date' => $request->released_date,
            'is_published' => 0,
            'category_id' => $request->category_id
        ]);

        BookAuthor::create([
            'book_id' => $book->id,
            'book_title' => $book->title,
            'author_id' => $author->id,
            'author_name' => $author->name,
            'is_published' => $book->is_published,
            'image' => $book->image
        ]);

        return redirect()->route('books.index');
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

    public function filter(FilterRequest $request)
    {
        $title = 'Not Found';
        $books = collect([]);

        if ($request->has('id')) {
            $books = Book::where('id', $request->id)->get();
            unset($title);
        }

        if ($request->title) {
            $books = Book::where('title', '%', $request->title)
                ->orderBy('created_at', 'desc')
                ->published()
                ->take(self::TOTAL_DEFAULT_ITEM)
                ->get();
            unset($title);
        }

        return view('admin.book.index')->with([
            'books' => $books,
            'title' => isset( $title)?? $title
        ]);
    }
}
