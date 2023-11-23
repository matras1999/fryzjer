@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Mój Profil</h1>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Zdjęcie profilowe
                    </div>
                    <div class="card-body">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Zdjęcie profilowe" class="img-fluid">
                        @else
                            <p>Brak zdjęcia profilowego</p>
                        @endif

                        <form action="{{ route('upload-avatar') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="avatar"> Zmień zdjęcie profilowe</label>
                                <input type="file" name="avatar" id="avatar" class="form-control-file">
                            </div>
                            <button type="submit" class="btn btn-primary">Prześlij</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Dane użytkownika
                    </div>
                    <div class="card-body">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Imię i Nazwisko</th>
                <td>{{ Auth::user()->name }}</td>
            </tr>
            <tr>
                <th>Adres email</th>
                <td>{{ Auth::user()->email }}</td>
            </tr>
            <!-- Dodaj pole numeru telefonu -->
            <tr>
                <th>Numer telefonu</th>
                <td>{{ Auth::user()->phone }}</td>
            </tr>
            <!-- Dodaj inne pola użytkownika, jeśli są dostępne -->
        </tbody>
    </table>
</div>
<!-- Przycisk "Edytuj dane" -->
<button id="editProfile" class="btn btn-primary">Edytuj dane</button>
<!-- Przycisk "Moje Rezerwacje" -->
        <a href="{{ route('zatwierdz') }}" class="btn btn-success mt-3">Moje Rezerwacje</a>



                </div>
            </div>
        </div>
    </div>


    <!-- Modal edycji danych użytkownika -->
<div id="editProfileModal" class="modal" style="width: 50%; left: 30%;border: 5px solid #ccc; max-height: 46vh; overflow-y: auto;">


    <div class="modal-content small">
        <span class="close" id="closeEditModal">&times;</span>
        <h2>Edytuj dane użytkownika</h2>
        <form action="{{ route('update-profile') }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Imię i Nazwisko</label>
                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Adres email</label>
                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="form-control">
            </div>
            <div class="form-group">
                <label for="phone">Numer telefonu</label>
                <input type="text" name="phone" id="phone" value="{{ Auth::user()->phone }}" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
        </form>
    </div>
</div>
<script>
    // Pokaż modal edycji po kliknięciu przycisku
    document.getElementById('editProfile').addEventListener('click', function () {
        document.getElementById('editProfileModal').style.display = 'block';
    });

    // Zamykaj modal po kliknięciu na krzyżyk lub poza modalem
    document.getElementById('closeEditModal').addEventListener('click', function () {
        document.getElementById('editProfileModal').style.display = 'none';
    });

    window.onclick = function (event) {
        if (event.target == document.getElementById('editProfileModal')) {
            document.getElementById('editProfileModal').style.display = 'none';
        }
    };
</script>
@endsection
