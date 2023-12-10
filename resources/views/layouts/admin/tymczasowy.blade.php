<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MatrasHair</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">MatrasHair</a>
        <ul class="navbar-nav ml-auto">
            @guest
                <!-- Linki logowania i rejestracji -->
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle user-menu" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Wyloguj się
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>

<div class="container">
    <h1>Odkryj nasze produkty</h1>
    <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addProductModal">Dodaj Produkt</button>
    <div class="row">
        @foreach ($produkty as $produkt)
        <div class="col-12 mb-3">
            <div class="card d-flex flex-row" style="border: 1px solid #6c757d;">
                <div class="card-header border-0">
                    <img src="{{ asset('storage/' . $produkt->obrazek) }}" alt="{{ $produkt->nazwa }}" style="width: 100px; height: 200px; object-fit: contain;">
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $produkt->nazwa }}</h5>
                        <p class="card-text">{{ $produkt->opis }}</p>
                        <p class="card-text">{{ number_format($produkt->cena, 2) }} zł</p>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editProductModal" data-id="{{ $produkt->id }}" data-nazwa="{{ $produkt->nazwa }}" data-opis="{{ $produkt->opis }}" data-cena="{{ $produkt->cena }}">Edytuj</a>
                        <form action="{{ route('admin.delete', $produkt->id) }}" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć ten produkt?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
</form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Modal dodawania produktu -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> 
        <h5 class="modal-title" id="addProductModalLabel">Dodaj Nowy Produkt</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Poprawnie -->
        <form id="addProductForm" method="POST" action="{{ route('admin.dodaj-produkt') }}" enctype="multipart/form-data">

          @csrf
          <div class="form-group">
            <label for="addProductName">Nazwa</label>
            <input type="text" class="form-control" id="addProductName" name="nazwa" required>
          </div>
          <div class="form-group">
            <label for="addProductDescription">Opis</label>
            <textarea class="form-control" id="addProductDescription" name="opis" required></textarea>
          </div>
          <div class="form-group">
            <label for="addProductPrice">Cena</label>
            <input type="number" class="form-control" id="addProductPrice" name="cena" required>
          </div>
          <div class="form-group">
            <label for="addProductImage">Obrazek</label>
            <input type="file" class="form-control-file" id="addProductImage" name="obrazek" required>
          </div>
          <button type="submit" class="btn btn-primary">Dodaj</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductModalLabel">Edytuj Produkt</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editProductForm" method="POST" action="{{ url('/admin/products/update/' . $produkt->id) }}">
          @csrf
          <input type="hidden" id="editProductId" name="id">
          <div class="form-group">
            <label for="editProductName">Nazwa</label>
            <input type="text" class="form-control" id="editProductName" name="nazwa">
          </div>
          <div class="form-group">
            <label for="editProductDescription">Opis</label>
            <textarea class="form-control" id="editProductDescription" name="opis"></textarea>
          </div>
          <div class="form-group">
            <label for="editProductPrice">Cena</label>
            <input type="number" class="form-control" id="editProductPrice" name="cena">
          </div>
          <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#editProductModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Przycisk, który wyzwolił modal
        var id = button.data('id'); // Pobranie atrybutu data-id z przycisku
        var nazwa = button.data('nazwa');
        var opis = button.data('opis');
        var cena = button.data('cena');

        var modal = $(this);
        modal.find('#editProductId').val(id); // Ustawienie wartości ukrytego pola ID
        modal.find('#editProductName').val(nazwa);
        modal.find('#editProductDescription').val(opis);
        modal.find('#editProductPrice').val(cena);

        // Dynamiczne ustawienie atrybutu action formularza
        modal.find('#editProductForm').attr('action', '/admin/products/update/' + id);
    });
});

</script>

</body>
</html>
