<?php

namespace App\Http\Controllers;

use App\Events\ProductUpdated;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function fetchProducts()
    {
        $response = Http::get('https://fakestoreapi.com/products');
        $products = $response->json();

        foreach ($products as $data) {
            $product = Product::create([
                'name' => $data['title'],
                'description' => $data['description'],
                'price' => $data['price'],
            ]);

            broadcast(new ProductUpdated($product))->toOthers();
        }

        return response()->json(['message' => 'Products fetched and broadcasted']);
    }

    public function index()
    {
        $products = Product::all();
        return view('welcome', compact('products'));
    }
}
