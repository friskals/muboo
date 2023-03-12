<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Author\StoreRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $per_page = isset($request->per_page) ? $request->per_page : 15;
        $authors = Author::paginate($per_page);
        return view('admin.author.index')->with('authors', $authors);
    }

    public function create()
    {
        return view('admin.author.create');
    }

    public function store(StoreRequest $request)
    {
        Author::create($request->validated());
        return redirect()->route('authors.index');
    }

    public function show($id)
    {
        $author = Author::findOrFail($id);

        return $author;
    }

    public function edit($id)
    {
        $author = Author::findOrfail($id);

        return view('admin.author.edit')->with('author', $author);
    }

    public function update(StoreRequest $request, $id)
    {
        $author = Author::findOrFail($id);

        $author->update($request->validated());

        return redirect()->route('authors.index');
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);

        $author->delete();

        return redirect()->route('authors.index');
    }
}
