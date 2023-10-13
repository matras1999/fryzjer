@extends('layouts.app')

@section('content')
    <div class="container">
    @if(\Session::has('message'))
        <div class="row">
            <div class="col-12 text-white bg-success">
                {{ \Session::get('message') }}
            </div>
        </div>
    @endif
        <div class="row">
            <div class="col-md-9 calendar-container"> <!-- Aktualizacja: Dodano klasę "calendar-container" -->
                <h2>Kalendarz</h2>
                <div id='calendar'></div>
            </div>
            <div class="col-md-3"> <!-- Aktualizacja: 1/4 szerokości ekranu -->
                <h2>Umów wizytę</h2>

                <form method="POST" action="{{ route('umow_wizyte') }}">
                    @csrf
                    <div class="form-group">
                        <label for="data">Data:</label>
                        <input type="date" class="form-control" name="data" required>
                    </div>
                    <div class="form-group">
                        <label for="godzina">Godzina:</label>
                        <input type="time" class="form-control" name="godzina" required>
                    </div>
                  <div class="form-group">
    <label for="rodzaj">Rodzaj wizyty:</label>
    <select class="form-control" name="rodzaj" id="rodzaj" required>
        <option value="" data-cena="0">--------</option>
        <option value="Cięcie zywkłe" data-cena="50">Cięcie Zwykłe - 50 zł</option>
        <option value="Wizyta 2" data-cena="75">Wizyta 2 - 75 zł</option>
        <option value="Wizyta 3" data-cena="100">Wizyta 3 - 100 zł</option>
        <!-- Dodaj więcej opcji, jeśli jest to konieczne -->
    </select>
    <input type="hidden" name="cena" id="cena" value="0">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var rodzajSelect = document.getElementById('rodzaj');
        var cenaInput = document.getElementById('cena');

        rodzajSelect.addEventListener('change', function() {
            var selectedOption = rodzajSelect.options[rodzajSelect.selectedIndex];
            var cena = selectedOption.getAttribute('data-cena');
            cenaInput.value = cena;
        });
    });
</script>



                   


                    <!-- Dodaj inne pola formularza, jeśli są potrzebne -->
                    <button type="submit" class="btn btn-primary">Umów wizytę</button>
                </form>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: @json($reservations),
                timeZone: 'Europe/Warsaw',
                timeFormat: 'H:mm' // Format godziny (24-godzinny)
            });

            calendar.render();
        });
    </script>

    <style>
        /* Aktualizacja: Dodano regułę CSS dla "calendar-container" */
        .calendar-container {
            width: 75%; /* 75% szerokości ekranu */
        }
    </style>
@endsection
