<!DOCTYPE html>
<html>
<head>
    <title>Potwierdzenie Zamówienia</title>
</head>
<body>
    <h1>Witaj {{ $user->name }},</h1>
    <p>Dziękujemy za Twoje zamówienie!</p>
    <p>Szczegóły zamówienia:</p>

    <ul>

        @foreach ($cartItems as $item)
            <li>{{ $item['name'] }} x {{ $item['quantity'] }}</li>
        @endforeach
    </ul>
    <p>Łączna kwota: {{ number_format($total, 2) }} zł</p>

</body>
</html>
