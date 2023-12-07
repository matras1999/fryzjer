{{-- koszyk.blade.php --}}

@extends('layouts.app')

<style>
    .koszyk-container {
        width: 80%;
        margin: auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd; /* Dodane ciemne obramowanie */
    }
    .koszyk-title {
        font-size: 24px;
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }
    .koszyk-list-group {
        list-style: none;
        padding: 0;
    }
    .koszyk-list-group .list-group-item {
        background-color: #eee;
        margin: 5px 0;
        padding: 10px;
        border-radius: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #ccc; /* Dodane ciemne obramowanie */
        transition: transform 0.2s; /* Animacja przy najechaniu */
    }
    .koszyk-list-group .list-group-item:hover {
        transform: scale(1.02); /* Lekkie powiększenie przy najechaniu */
        border-color: #bbb; /* Zmiana koloru obramowania */
    }
    .koszyk-button {
        display: block;
        width: calc(100% - 20px); /* Poprawka na padding */
        padding: 10px;
        margin-top: 20px;
        text-align: center;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        cursor: pointer; /* Dodanie kursora wskazującego */
        transition: background-color 0.3s; /* Animacja tła */
    }
    .koszyk-button:hover {
        background-color: #0056b3; /* Ciemniejszy odcień niebieskiego przy najechaniu */
    }
    .koszyk-summary {
    text-align: right;
    margin-top: 10px;
    font-size: 18px;
    padding: 10px;
    border-top: 1px solid #ccc; /* Dodaje linię oddzielającą */
}
.list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .remove-item-btn {
        /* Style dla przycisku usuń */
        padding: 0.375rem 0.75rem; /* Bootstrap's default padding for buttons */
    }
    .koszyk-button {
        /* Twoje style dla głównego przycisku */
    }
</style>
@section('content')
<div class="koszyk-container">
    <div class="koszyk-title">Podsumowanie zamówienia</div>
    @if (count($cartItems) > 0)
        <ul class="koszyk-list-group list-group">
            @php $total = 0; @endphp
            @foreach ($cartItems as $item)
                @php $lineTotal = $item['price'] * $item['quantity']; @endphp
                @php $total += $lineTotal; @endphp
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $item['name'] }} x {{ $item['quantity'] }} - {{ number_format($lineTotal, 2) }} zł
                    <button type="button" class="btn btn-danger remove-item-btn" data-id="{{ $item['id'] }}" data-price="{{ $item['price'] }}">Usuń</button>
                </li>
            @endforeach
        </ul>
        <div class="koszyk-summary">
            <strong>Łącznie do zapłaty: <span id="total-price">{{ number_format($total, 2) }} zł</span></strong>
        </div>
        <form action="{{ route('confirmOrder') }}" method="post">
        @csrf
        @foreach ($cartItems as $item)
            <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $item['id'] }}">
            <input type="hidden" name="items[{{ $loop->index }}][name]" value="{{ $item['name'] }}">
            <input type="hidden" name="items[{{ $loop->index }}][quantity]" value="{{ $item['quantity'] }}">
            <input type="hidden" name="items[{{ $loop->index }}][price]" value="{{ $item['price'] }}">
        @endforeach
        <button type="submit" class="koszyk-button button">Złóż zamówienie</button>
    </form>
    @else
        <p>Brak dodanych produktów</p>
        <a href="{{ route('produkty') }}" class="btn btn-primary">Przejdź do sklepu</a>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const removeButtons = document.querySelectorAll('.remove-item-btn');

    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.getAttribute('data-id');
            // Usuń element z listy
            const listItem = this.closest('.list-group-item');
            listItem.parentNode.removeChild(listItem);

            // Znajdź cenę produktu i odejmij ją od całkowitej ceny
            const itemPrice = parseFloat(this.dataset.price);
            const totalPriceElement = document.getElementById('total-price');
            let currentTotal = parseFloat(totalPriceElement.textContent.replace(' zł', ''));
            const newTotal = currentTotal - itemPrice;
            totalPriceElement.textContent = newTotal.toFixed(2) + ' zł';

            // Sprawdź, czy koszyk jest teraz pusty
            if (document.querySelectorAll('.list-group-item').length === 0) {
                document.querySelector('.koszyk-container').innerHTML = '<p>Koszyk jest pusty.</p><a href="{{ route('produkty') }}" class="btn btn-primary">Przejdź do sklepu</a>';
            }
        });
    });
});
</script>
@endsection
