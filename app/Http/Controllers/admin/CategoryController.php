<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\category\StoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
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

    public function update($id, Request $request)
    {
        $category = Category::findOrFail($id);

        $category->update(['name' => $request->name]);

        return "ok";
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return "ok";
    }
}
