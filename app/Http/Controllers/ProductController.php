<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use App\Events\ProductUpdated;

class ProductController extends Controller
{
    public function fetchProducts()
    {
        $response = Http::get('https://fakestoreapi.com/products');
        $products = $response->json();

        foreach ($products as $product) {
            $newProduct = Product::updateOrCreate(
                ['name' => $product['title']],
                [
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'category' => $product['category'],
                    'image' => $product['image'],
                    'rating' => $product['rating']['rate'],
                    'rating_count' => $product['rating']['count'],
                ]
            );

            event(new ProductUpdated($newProduct));
        }

        return response()->json(['message' => 'Products fetched successfully']);
    }

    public function index()
    {
        return view('products.index', ['products' => Product::all()]);
    }
}
