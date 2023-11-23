@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Zarządzanie Sklepem - Dodaj Produkt</h1>

    <form action="{{ route('admin.dodaj-produkt') }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- Token CSRF -->
        <div class="form-group">
            <label for="nazwa">Nazwa Produktu</label>
            <input type="text" class="form-control" id="nazwa" name="nazwa" required>
        </div>
        <div class="form-group">
            <label for="opis">Opis Produktu</label>
            <textarea class="form-control" id="opis" name="opis" required></textarea>
        </div>
        <div class="form-group">
            <label for="cena">Cena Produktu</label>
            <input type="number" class="form-control" id="cena" name="cena" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="obrazek">Zdjęcie Produktu</label>
            <input type="file" class="form-control-file" id="obrazek" name="obrazek" required>
        </div>
        <button type="submit" class="btn btn-primary">Dodaj Produkt</button>
    </form>
</div>
@endsection
