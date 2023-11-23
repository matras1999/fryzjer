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
.product-row button.remove-button {
    background-color: red;
    color: #fff;
    float:right;
    
    
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

    <button id="myButton" class="btn btn-warning" style="position: fixed; right: 45px; top: 80px;">
        <i class="fas fa-shopping-cart fa-2x"></i>
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

    document.addEventListener('DOMContentLoaded', function () {
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

        // Aktualizacja zawartości modala koszyka
        function updateCartModal() {
    var cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    var modalBodyElement = document.querySelector('#myModal .modal-body');
    modalBodyElement.innerHTML = ''; // Wyczyść aktualną zawartość

    // Użyj obiektu Set do przechowywania unikalnych produktów
    var uniqueItems = new Set(cartItems.map(item => JSON.stringify(item)));
    var uniqueItemsArray = Array.from(uniqueItems).map(item => JSON.parse(item));

   uniqueItemsArray.forEach(function (item, index) {
    var productRow = document.createElement('div');
    productRow.classList.add('product-row');

    var productName = document.createElement('span');
    productName.textContent = item.name + ' - Cena: ' + item.price.toFixed(2) + ' zł';
    productRow.appendChild(productName);

    var removeButton = document.createElement('button');
    removeButton.textContent = 'Usuń';
    removeButton.classList.add('remove-button'); // Dodaj klasę do przycisku
    removeButton.addEventListener('click', function () {
        // Usuń produkt z koszyka po kliknięciu przycisku "Usuń"
        cartItems.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cartItems));

        // Ponownie zaktualizuj zawartość modala
        updateCartModal();
    });
    productRow.appendChild(removeButton);

    modalBodyElement.appendChild(productRow);
});
var summaryButton = document.querySelector('#summaryButton');
summaryButton.style.display = cartItems.length > 0 ? 'block' : 'none';

summaryButton.addEventListener('click', function (event) {
    event.preventDefault();
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
    }, 300); // 2000 milisekund (czyli 2 sekundy)
}
            
        });
    }
});
}

        // Dodanie produktów do koszyka
        document.querySelectorAll('.addToCartButton').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                var id = this.dataset.id;
                var name = this.dataset.nazwa;
                var price = parseFloat(this.dataset.cena);

                var cartItems = JSON.parse(localStorage.getItem('cart')) || [];

                var productToAdd = {
                    id: id,       // Użyj rzeczywistego id produktu
                    name: name,   // Użyj rzeczywistej nazwy produktu
                    price: price  // Użyj rzeczywistej ceny produktu
                };

                cartItems.push(productToAdd);

                localStorage.setItem('cart', JSON.stringify(cartItems));

                // Aktualizuj i pokaż modal z koszykiem
                updateCartModal();
                document.getElementById("myModal").style.display = "block";
            });
        });
    });

</script>


@endsection
