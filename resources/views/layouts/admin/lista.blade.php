<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Klientów</title>
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
    <div class="container mt-4">
        <h2>Lista Klientów</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Imię i nazwisko</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Avatar</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    @if ($user->role == 'user') <!-- Wyświetlanie tylko użytkowników z rolą 'user' -->
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td> <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar użytkownika" class="img-fluid" style="max-width: 100px; height: auto;"></td>
                            <td>
                                <form action="{{ route('usun-klienta', $user->id) }}" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć tego użytkownika?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
