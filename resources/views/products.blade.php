<ul>
    <li>Product 1</li>
    <li>Product 2</li>

    @if (isset($products))
        @foreach ($products as $product)
            <li>{{ $product->title }}</li>
        @endforeach
    @endif

</ul>
