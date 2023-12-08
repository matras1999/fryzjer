<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ustaw Grafik - Panel Administracyjny - MigdaHair</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">MigdaHair</a>
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
        <h2>Ustaw Grafik Pracowników</h2>
        <form action="{{ route('admin.zapisz-grafik') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="fryzjerSelect">Wybierz fryzjera:</label>
                <select class="form-control" id="fryzjerSelect" name="fryzjer_id">
                    @foreach ($fryzjerzy as $fryzjer)
                        <option value="{{ $fryzjer->id }}">{{ $fryzjer->imie }} {{ $fryzjer->nazwisko }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="data">Wybierz dni:</label>
                <input type="text" class="form-control" id="data" name="daty[]" readonly>
            </div>

            <div class="form-group">
    <label for="godzinaOd">Godzina rozpoczęcia:</label>
    <input type="time" class="form-control" id="godzinaOd" name="godzina_od">
</div>

<div class="form-group">
    <label for="godzinaDo">Godzina zakończenia:</label>
    <input type="time" class="form-control" id="godzinaDo" name="godzina_do">
</div>

            <button type="submit" class="btn btn-primary">Zapisz Grafik</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
   <script>
    $(document).ready(function(){
        $('#data').datepicker({
            format: 'yyyy-mm-dd',
            multidate: true,
            startDate: '-0d',
            autoclose: false
        }).on('changeDate', function(e){
            $('.dates').remove(); // Usuń wszystkie poprzednie ukryte pola

            if (e.dates.length > 0) {
                // Utwórz tablicę dat z indeksu 0
                var datesArray = e.dates[0].split(',');
                $(datesArray).each(function(index, date){
                    var firstDate = datesArray[0];
                    $('#data').after('<input type="hidden" class="dates" name="daty[]" value="' + date.trim() + '">');
                });
            }
        });
    });
</script>




</body>
</html>
