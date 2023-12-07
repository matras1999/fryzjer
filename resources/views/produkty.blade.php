@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f0f0f0; /* Kolor tła strony */
    }

    .card {
     
        border: none;
        border-radius: 10px;
        overflow: hidden;
    }

    .card-title {
        font-size: 2.5rem;
    }

    .card-text {
        font-size: 1rem;
    }

    .btn-primary {
        background-color: #007bff; /* Kolor przycisku "Dodaj do koszyka" */
        border: none;
    }

    .btn-warning {
        background-color: #ffc107; /* Kolor przycisku "Koszyk" */
        border: none;
    }

    .btn-primary:hover, .btn-warning:hover {
        background-color: #0056b3; /* Kolor przycisków po najechaniu myszą */
    }

   .modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    ccolor: #aaa;
    float: left; /* To zapewni, że 'X' będzie z prawej strony */
    font-size: 28px;
    font-weight: bold;
    margin-left: 100px; /* Dodaje odstęp od prawej krawędzi */
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

h2 {
    margin-top: 0;
    color: #333;
}
.product-row {
    display: flex;
    justify-content: space-between; /* Zapewnia, że dzieci są wyrównane do lewej i prawej krawędzi kontenera */
    align-items: center; /* Wyrównuje dzieci w pionie */
    padding: 5px 0; /* Dodaje nieco paddingu dla lepszego wyglądu */
}
.product-row .remove-button {
    background-color: red;
    color: #fff;
    border: none; /* Usuń domyślny styl obramowania */
    padding: 5px 10px; /* Dodaj padding dla lepszego wyglądu */
    cursor: pointer; /* Kursor pokazujący, że jest to klikalny przycisk */
     /* Dodaje odstęp od innych elementów, jeśli to konieczne */
}

a.relative {
    background-color: #f8f9fa; /* Jasne tło */
    border: 10px solid #dee2e6; /* Ramka */
    padding: 0.5rem 1rem; /* Padding wokół tekstu */
    margin: 0 0.25rem; /* Margines pomiędzy linkami */
    font-weight: bold; /* Pogrubiona czcionka */
    color: #007bff; /* Kolor tekstu */
    text-decoration: none; /* Usunięcie podkreślenia */

}

.pagination {
    display: flex;
    justify-content: flex-end; /* Wyrównuje dzieci kontenera do prawej strony */
}

/* Styl dla aktywnego numeru strony */
span.relative {
display: none;
}



}



svg.w-5.h-5 {
    display: none;
}

</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<div class="container">
    <h1>Odkryj nasze produkty</h1>
    <p class="lead">Przeglądaj naszą starannie wyselekcjonowaną ofertę produktów fryzjerskich. Każdy produkt został wybrany ze względu na swoją najwyższą jakość, wydajność i innowacyjność. Z nami Twoje włosy będą w najlepszych rękach!</p>
    <div class="row">
        @foreach ($produkty as $produkt)
        <div class="col-12 mb-3">
            <div class="card d-flex flex-row" style="border: 1px solid #6c757d;"> <!-- Dodane grafitowe obramowanie -->
                <div class="card-header border-0">
                    <img src="{{ asset('storage/' . $produkt->obrazek) }}" alt="{{ $produkt->nazwa }}" style="width: 100px; height: 200px; object-fit: contain;">
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $produkt->nazwa }}</h5>
                        <p class="card-text">{{ $produkt->opis }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <p class="card-text">{{ number_format($produkt->cena, 2) }} zł</p>
                        <a href="#" class="btn btn-primary btn-sm addToCartButton" 
                           data-id="{{ $produkt->id }}" 
                           data-nazwa="{{ $produkt->nazwa }}" 
                           data-cena="{{ $produkt->cena }}">Dodaj do koszyka</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <div class="pagination">
    {{ $produkty->onEachSide(0)->links() }}
</div>
    <button id="myButton" class="btn btn-warning" style="position: fixed; right: 45px; top: 80px;">
        <i class="fas fa-shopping-cart fa-2x"></i>
        <span class="liczba-produktow" id="liczbaProduktow">0</span>
    </button>

    <!-- Modal -->
    <div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <h3>Twój koszyk</h3>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <p>Treść koszyka...</p>
        </div>
        <div class="modal-footer">
            <button id="summaryButton" class="btn btn-success">Przejdź do podsumowania</button>
        </div>
    </div>
</div>
</div>

<script>
    // Funkcja do inicjalizacji koszyka przy pierwszym załadowaniu strony
    function initializeCart() {
        if (!getCookie('cart')) {
            setCookie('cart', JSON.stringify([]), 5 / (24 * 60)); // Ustawiamy ciasteczko z ważnością 1 minuty
        }
    }

    // Funkcja do pobierania wartości ciasteczka
    function getCookie(name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }

    // Funkcja do ustawiania wartości ciasteczka
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    // Funkcja do aktualizacji zawartości modala koszyka
    function updateCartModal() {
        var cartItems = JSON.parse(getCookie('cart')) || [];
        var modalBodyElement = document.querySelector('#myModal .modal-body');
        modalBodyElement.innerHTML = ''; // Wyczyść aktualną zawartość

        cartItems.forEach(function (item, index) {
            var productRow = document.createElement('div');
            productRow.classList.add('product-row');

            var productName = document.createElement('span');
            productName.textContent = item.name + ' x ' + item.quantity + ' - Cena: ' + (item.price * item.quantity).toFixed(2) + ' zł';
            productRow.appendChild(productName);

            var removeButton = document.createElement('button');
            removeButton.textContent = 'Usuń';
            removeButton.classList.add('remove-button');
            removeButton.addEventListener('click', function () {
                cartItems.splice(index, 1);
                setCookie('cart', JSON.stringify(cartItems), 1 / (24 * 60)); // Aktualizuj ciasteczko na 1 minutę
                updateCartModal();
                updateCartCount(); // Aktualizuj liczbę produktów
            });
            productRow.appendChild(removeButton);

            modalBodyElement.appendChild(productRow);
        });

        var summaryButton = document.querySelector('#summaryButton');
        summaryButton.style.display = cartItems.length > 0 ? 'block' : 'none';
    }

    // Funkcja do aktualizacji liczby produktów w koszyku
    function updateCartCount() {
        var cartItems = JSON.parse(getCookie('cart')) || [];
        var count = cartItems.reduce((sum, item) => sum + item.quantity, 0);
        document.getElementById('liczbaProduktow').textContent = count;
    }

    // Funkcja dodająca produkt do koszyka
    function addToCart(productToAdd) {
        var cartItems = JSON.parse(getCookie('cart')) || [];
        var existingItem = cartItems.find(item => item.id === productToAdd.id);

        if (existingItem) {
            existingItem.quantity += 1; // Zwiększ ilość, jeśli produkt już jest w koszyku
        } else {
            productToAdd.quantity = 1; // Ustaw ilość na 1 dla nowego produktu
            cartItems.push(productToAdd);
        }

        setCookie('cart', JSON.stringify(cartItems), 1 / (24 * 60)); // Aktualizuj ciasteczko na 1 minutę
        updateCartModal();
        updateCartCount();
    }

    document.addEventListener('DOMContentLoaded', function () {
        initializeCart(); // Inicjalizuj koszyk
        // Przycisk otwierający modal koszyka
        document.getElementById("myButton").onclick = function () {
            document.getElementById("myModal").style.display = "block";
            updateCartModal(); // Aktualizuj koszyk za każdym razem, gdy otwierasz modal
        };

        // Przycisk zamykający modal koszyka
        document.querySelector(".modal-header .close").onclick = function () {
            document.getElementById("myModal").style.display = "none";
        };

        // Zamknięcie modala poprzez kliknięcie poza jego obszarem
        window.onclick = function (event) {
            if (event.target == document.getElementById("myModal")) {
                document.getElementById("myModal").style.display = "none";
            }
        };

        // Dodanie produktów do koszyka
        document.querySelectorAll('.addToCartButton').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                var id = this.dataset.id;
                var name = this.dataset.nazwa;
                var price = parseFloat(this.dataset.cena);

                var productToAdd = {
                    id: id,
                    name: name,
                    price: price
                };

                addToCart(productToAdd); // Użyj funkcji addToCart
            });
        });

        // Obsługa przycisku "Przejdź do podsumowania"
        document.querySelector('#summaryButton').addEventListener('click', function (event) {
            event.preventDefault();
            var cartItems = JSON.parse(getCookie('cart')) || [];
            if (cartItems.length > 0) {
                // Przygotuj dane do wysłania
                var requestData = {
                    cartItems: cartItems
                };

                // Wyślij dane do kontrolera za pomocą jQuery.ajax
                $.ajax({
                    type: 'POST',
                    url: '/przejdz-do-podsumowania',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { cartItems: requestData },
                    success: function(response) {
                        // Opóźnienie przekierowania o 2 sekundy
                        setTimeout(function() {
                            // Przekierowanie użytkownika do widoku "koszyk.blade.php"
                            window.location.href = 'koszyk';
                        }, 2000);
                    }
                });
            }
        });

        // Wywołanie updateCartCount przy ładowaniu strony
        updateCartCount();
    });
</script>




@endsection
