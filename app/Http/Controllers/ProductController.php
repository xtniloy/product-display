<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Product;
use App\Events\ProductUpdated;

class ProductController extends Controller
{
    public function fetchProducts()
    {
        $client = new Client();
        $response = $client->get('https://fakestoreapi.com/products');

        if ($response->getStatusCode() == 200) {
            $products = json_decode($response->getBody()->getContents(), true);

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
        }

        return response()->json(['message' => 'Products fetched successfully']);
    }

    public function index()
    {
        return view('products.index', ['products' => Product::all()]);
    }
}
