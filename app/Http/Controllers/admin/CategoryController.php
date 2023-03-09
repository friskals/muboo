<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    const PAGINATION_DEFAULT = 15;

    public function create()
    {
        return view('admin.category.create');
    }

    public function index()
    {
        $categories = Category::paginate(self::PAGINATION_DEFAULT);

        return view('admin.category.index')->with('categories', $categories);
    }

    public function store(StoreRequest $request)
    {
        $category = [];
        $category['slug'] = Str::slug($request->name);
        $category = array_merge($category, $request->validated());
        Category::create($category);

        return redirect()->route('categories.index');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return $category;
    }


    public function edit(Category $category)
    {
        return view('admin.category.edit', ['category' => $category]);
    }

    public function update($id, UpdateRequest $request)
    {
        $category = Category::findOrFail($id);

        $category->update($request->validated());

        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->isActive()) {
            return back()->withErrors("Active category can't be deleted");
        }

        $usedInBook = Book::where('category_id', $id)->count();

        if ($usedInBook) {
            return back()->withErrors('Category is being used in book');
        }

        $category->delete();

        return redirect()->route('categories.index');
    }
}
