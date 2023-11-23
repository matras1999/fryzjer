{{-- Przykładowa zawartość koszyk.blade.php --}}
<ul class="list-group">
    @foreach ($cartItems as $item)
        <li class="list-group-item">
            {{ $item['name'] }} - {{ $item['price'] }} zł
        </li>

    @endforeach
</ul>
