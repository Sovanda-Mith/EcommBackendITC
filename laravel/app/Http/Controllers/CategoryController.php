<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json(['categories' => $categories, 'message' => 'success']);
    }

    public function createCategory(Request $request)
    {
        $validated = $request->validate(
            ["name" => "required|unique:categories,name"]
        );

        $category = Category::create(["name" => $validated['name']]);

        return response()->json(["message" => "Category " . $validated['name'] . " created"]);
    }

    public function getCategory($categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Category not found"], 404);
        }

        return response()->json(["message" => "success", "category" => $category]);
    }

    public function updateCategory($categoryId, Request $request)
    {
        $validated = $request->validate(
            ["name" => "required|unique:categories,name"]
        );

        try {
            $category = Category::findOrFail($categoryId);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Category not found"], 404);
        }

        $category->name = $validated['name'];
        $category->save();

        return response()->json(["message" => "success"]);
    }

    public function deleteCategory($categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Category not found"], 404);
        }

        $category->delete();

        return response()->json(["message" => "success"]);
    }
}
