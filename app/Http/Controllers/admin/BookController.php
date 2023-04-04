<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Book\FilterRequest;
use App\Http\Requests\Admin\Book\StoreRequest;
use App\Http\Requests\Admin\Book\UpdateRequest;
use App\Http\Requests\Admin\Book\UpdateStatusRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
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

        $category = Category::findOrFail($request->category_id);

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

    public function edit($id)
    {
        $authors = Author::select('id', 'name')->get();

        $categories = Category::select('id', 'name')->isActive()->get();

        $bookAuthor = BookAuthor::firstWhere('book_id', $id);

        $book = Book::findOrFail($id);

        $category = $categories->firstWhere('id', $book->category_id);

        $bookAuthor->category = $category->name;

        $bookAuthor->releasedDate = $book->released_date;

        return view('admin.book.edit')->with([
            'authors' => $authors,
            'categories' => $categories,
            'book' => $bookAuthor
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        $bookUpdate = [];
        $bookAuthorUpdate = [];

        if ($request->author_id) {
            $author = Author::find($request->author_id);
            $bookAuthorUpdate['author_id'] = $author->id;
            $bookAuthorUpdate['author_name'] = $author->name;
        }

        if ($request->category_id) {
            $bookUpdate['category_id'] = $request->category_id;
        }

        if ($request->title) {
            $bookAuthorUpdate['book_title'] = $request->title;
            $bookUpdate['title'] = $request->title;
        }


        if ($image = $request->file('image')) {

            $bookUpdate['image'] = $image->storeAs(
                'images',
                $image->getClientOriginalName(),
                'public'
            );

            Storage::disk('public')->delete($book->image);
        }


        if (count($bookUpdate)) {
            $book->update($bookUpdate);
        }

        if (count($bookAuthorUpdate)) {
            BookAuthor::where('book_id', $book->id)->update($bookAuthorUpdate);
        }

        session()->flash('success', 'Book updated successfully');

        return redirect()->route('books.index');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        Storage::disk('public')->delete($book->image);

        $book->delete();

        session()->flash('success', 'Book deleted successfully');

        return redirect()->route('books.index');
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

        if ($request->id) {
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
            'title' => isset($title) ?? $title
        ]);
    }

    public function updateStatus(UpdateStatusRequest $request)
    {

        $book = Book::findOrFail($request->book_id);

        $new_status = $book->is_published ? 0 : 1;

        $book->update(['is_published' => $new_status]);

        Session::flash('success', "Book successfully " . ($new_status ? "published" : "unpublished"));

        return redirect()->route('books.index');
    }
}
