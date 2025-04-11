<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
</head>
<body>
    <h1>Product List</h1>
    <ul id="product-list">
        @foreach($products as $product)
            <li><strong>{{ $product->name }}</strong>: {{ $product->description }} - ${{ $product->price }}</li>
        @endforeach
    </ul>

    <script>
        Pusher.logToConsole = true;

        const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}'
        });

        const channel = pusher.subscribe('products');
        channel.bind('product.update', function(data) {
            const list = document.getElementById('product-list');
            const li = document.createElement('li');
            li.innerHTML = `<strong>${data.name}</strong>: ${data.description} - $${data.price}`;
            list.appendChild(li);
        });
    </script>
</body>
</html>