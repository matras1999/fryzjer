<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Pracy - MatrasHair</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .today {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .table th {
            background-color: #007bff;
            color: #fff;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
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
        <h2>Grafik Pracy Fryzjera</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Dzień</th>
                    <th>Data</th>
                    <th>Godzina Rozpoczęcia</th>
                    <th>Godzina Zakończenia</th>
                </tr>
            </thead>
            <tbody>
                @php \Carbon\Carbon::setLocale('pl'); @endphp
                @foreach ($grafik as $wpis)
                    <tr class="{{ $wpis->date == date('Y-m-d') ? 'today' : '' }}">
                        <td>{{ \Carbon\Carbon::parse($wpis->date)->isoFormat('dddd') }}</td>
                        <td>{{ $wpis->date }}</td>
                        <td>{{ $wpis->start_time }}</td>
                        <td>{{ $wpis->end_time }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Skrypty JavaScript -->
</body>
</html>
