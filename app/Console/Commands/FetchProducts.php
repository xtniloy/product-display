<?php

namespace App\Console\Commands;

use App\Events\ProductUpdated;
use Illuminate\Console\Command;
use App\Models\Product;
use GuzzleHttp\Client;
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

            $this->info('Products fetched successfully.');
        } else {
            $this->error('Failed to fetch products.');
        }
    }
}
