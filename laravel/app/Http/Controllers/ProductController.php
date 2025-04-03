<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts()
    {
        $products = Product::all();

        return response()->json(["products" => $products, "message" => "success"]);
    }

    public function createProduct(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|unique:products,name",
            "category_id" => "required|exists:categories,id",
            "description" => "nullable|string",
            "pricing" => "required|numeric",
            "images" => "nullable|json"
        ]);

        $newProduct = new Product();

        $newProduct->name = $validated['name'];
        $newProduct->category_id = $validated['category_id'];
        $newProduct->description = $validated['description'];
        $newProduct->pricing = $validated['pricing'];
        $newProduct->images = $validated['images'];

        $newProduct->save();

        return response()->json(["message" => "success"]);
    }

    public function getProduct($productId)
    {
        try {
            $product = Product::findOrFail($productId);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Product not found"], 404);
        }

        return response()->json(["product" => $product, "message" => "success"]);
    }

    public function updateProduct($productId, Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|unique:products,name",
            "category_id" => "required|exists:categories,id",
            "description" => "nullable|string",
            "pricing" => "required|numeric",
            "images" => "nullable|json"
        ]);

        try {
            $product = Product::findOrFail($productId);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Product not found"], 404);
        }

        $product->name = $validated['name'];
        $product->category_id = $validated['category_id'];
        $product->description = $validated['description'];
        $product->pricing = $validated['pricing'];
        $product->images = $validated['images'];

        $product->save();

        return response()->json(["message" => "success"]);
    }

    public function deleteProduct($productId)
    {
        try {
            $product = Product::findOrFail($productId);
        } catch (ModelNotFoundException $e) {
            return response()->json(["message" => "Product not found"], 404);
        }

        $product->delete();

        return response()->json(["message" => "success"]);
    }

    public function getProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();

        return response()->json(["products" => $products, "message" => "success"]);
    }
}
