<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            encrypted: true
        });

        var channel = pusher.subscribe("products");
        channel.bind("App\\Events\\ProductUpdated", function(data) {
            let productList = document.getElementById("product-list");
            let newProduct = `
                <div>
                    <img src="${data.product.image}" alt="${data.product.name}" width="100">
                    <h3>${data.product.name}</h3>
                    <p>${data.product.description}</p>
                    <p><strong>Category:</strong> ${data.product.category}</p>
                    <p><strong>Price:</strong> $${data.product.price}</p>
                    <p><strong>Rating:</strong> ${data.product.rating} (${data.product.rating_count} reviews)</p>
                </div>
            `;
            productList.innerHTML += newProduct;
        });
    </script>
</head>
<body>
<h1>Product List</h1>
<div id="product-list">
    @foreach ($products as $product)
        <div>
            <img src="{{ $product->image }}" alt="{{ $product->name }}" width="100">
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->description }}</p>
            <p><strong>Category:</strong> {{ $product->category }}</p>
            <p><strong>Price:</strong> ${{ $product->price }}</p>
            <p><strong>Rating:</strong> {{ $product->rating }} ({{ $product->rating_count }} reviews)</p>
        </div>
    @endforeach
</div>
</body>
</html>
