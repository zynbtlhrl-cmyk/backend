<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        $category = Category::create($request->all());

        return response()->json($category);
    }

public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255'
    ]);

    $category->update([
        'name' => $request->name
    ]);

    return response()->json($category);
}
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'deleted'
        ]);
    }
}

