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
        <form action="{{ route('confirmOrder') }}" method="post">
            @csrf
            <ul class="koszyk-list-group list-group">
                @php $total = 0; @endphp
                @foreach ($cartItems as $item)
                    @php $lineTotal = $item['price'] * $item['quantity']; @endphp
                    @php $total += $lineTotal; @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            {{ $item['name'] }} - {{ number_format($lineTotal, 2) }} zł
                        </div>
                        <div>
                            Ilość: 
                            <button type="button" class="btn btn-success change-quantity" data-id="{{ $item['id'] }}" data-increase="true" data-price="{{ $item['price'] }}">+</button>
                            <span class="quantity">{{ $item['quantity'] }}</span>
                            <button type="button" class="btn btn-warning change-quantity" data-id="{{ $item['id'] }}" data-increase="false" data-price="{{ $item['price'] }}">-</button>
                            <button type="button" class="btn btn-danger remove-item-btn" data-id="{{ $item['id'] }}" data-price="{{ $item['price'] }}">Usuń</button>
                        </div>
                        <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $item['id'] }}">
                        <input type="hidden" name="items[{{ $loop->index }}][name]" value="{{ $item['name'] }}">
                        <input type="hidden" class="item-quantity" name="items[{{ $loop->index }}][quantity]" value="{{ $item['quantity'] }}">
                        <input type="hidden" class="item-price" name="items[{{ $loop->index }}][price]" value="{{ $item['price'] }}">
                    </li>
                @endforeach
            </ul>
            <div class="koszyk-summary">
                <strong>Łącznie do zapłaty: <span id="total-price">{{ number_format($total, 2) }} zł</span></strong>
            </div>
            <button type="submit" class="koszyk-button button">Złóż zamówienie</button>
        </form>
        <form action="{{ route('usunWszystkieProdukty') }}" method="post">
            @csrf
            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-danger">Usuń wszystkie produkty</button>
            </div>
        </form>
    @else
        <p>Brak dodanych produktów</p>
        <a href="{{ route('produkty') }}" class="btn btn-primary">Przejdź do sklepu</a>
    @endif
</div>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const removeButtons = document.querySelectorAll('.remove-item-btn');
    const changeQuantityButtons = document.querySelectorAll('.change-quantity');
    const totalPriceElement = document.getElementById('total-price');
    let currentTotal = parseFloat(totalPriceElement.textContent.replace(' zł', ''));

    function updateTotalAndLineTotal(quantityElement, itemPrice, isIncrease) {
        let quantity = parseInt(quantityElement.textContent);
        const oldLineTotal = quantity * itemPrice;

        if (isIncrease) {
            quantity++;
        } else {
            if (quantity > 1) {
                quantity--;
            } else {
                return; // Zatrzymaj, jeśli ilość jest mniejsza niż 1
            }
        }

        const newLineTotal = quantity * itemPrice;
        quantityElement.textContent = quantity; // Aktualizuj ilość w DOM
        const lineTotalElement = quantityElement.closest('.list-group-item').querySelector('.line-total');
        if (lineTotalElement) {
            lineTotalElement.textContent = newLineTotal.toFixed(2) + ' zł'; // Aktualizuj linię ceny produktu
        }

        // Aktualizuj całkowitą cenę
        currentTotal += isIncrease ? itemPrice : -itemPrice;
        totalPriceElement.textContent = currentTotal.toFixed(2) + ' zł';

        // Aktualizuj ukryte pole formularza z ilością
        const hiddenQuantityInput = quantityElement.closest('.list-group-item').querySelector('.item-quantity');
        hiddenQuantityInput.value = quantity;
    }

    changeQuantityButtons.forEach(button => {
        button.addEventListener('click', function () {
            const itemPrice = parseFloat(this.dataset.price);
            const quantityElement = this.closest('.list-group-item').querySelector('.quantity');
            const isIncrease = this.dataset.increase === "true";
            updateTotalAndLineTotal(quantityElement, itemPrice, isIncrease);
        });
    });

    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const listItem = this.closest('.list-group-item');
            const itemPrice = parseFloat(this.dataset.price);
            const quantity = parseInt(listItem.querySelector('.quantity').textContent);
            const priceReduction = itemPrice * quantity;
            
            currentTotal -= priceReduction;
            totalPriceElement.textContent = currentTotal.toFixed(2) + ' zł';
            
            listItem.remove(); // Usuwa element z DOM
            
            // Sprawdź, czy koszyk jest teraz pusty
            if (!document.querySelectorAll('.list-group-item').length) {
                document.querySelector('.koszyk-container').innerHTML = '<p>Koszyk jest pusty.</p><a href="{{ route('produkty') }}" class="btn btn-primary">Przejdź do sklepu</a>';
            }
        });
    });
});
</script>



@endsection
