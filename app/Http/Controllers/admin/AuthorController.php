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
        return Author::paginate($per_page); 
    }

    public function store(StoreRequest $request){
        Author::create($request->validated());
        return true;
    }

    public function show($id){
        $author = Author::findOrFail($id);

        return $author;
    }

    public function update(StoreRequest $request, $id){
        $author = Author::findOrFail($id);

        $author->update($request->validated());

        return true;
    }

    public function destroy($id){
        $author = Author::findOrFail($id);

        $author->delete();

        return true;
    }
}
