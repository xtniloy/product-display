<?php

namespace App\Console\Commands;

use App\Events\ProductUpdated;
use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
class FetchProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch products from Fake Store API and save to the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://fakestoreapi.com/products');

        if ($response->successful()) {
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

            $this->info('Products fetched successfully.');
        } else {
            $this->error('Failed to fetch products.');
        }
    }
}
