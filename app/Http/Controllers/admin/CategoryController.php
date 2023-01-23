<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\category\StoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(StoreRequest $request)
    {
        Category::create($request->validated());
        return "ok";
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
