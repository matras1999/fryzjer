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
            <div class="col-md-9 calendar-container">
                <h2>Kalendarz</h2>
                <div id='calendar'></div>
            </div>
            <div class="col-md-3">
                <h2>Umów wizytę</h2>

                <form method="POST" action="{{ route('umow_wizyte') }}">
                    @csrf
                    <div class="form-group">
    <label for="data">Data:</label>
    <input type="date" class="form-control" name="data" required>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dataInput = document.querySelector('input[name="data"]');

        dataInput.addEventListener('input', function() {
            var selectedDate = new Date(dataInput.value);
            if (selectedDate.getDay() === 0) { // Sprawdź, czy wybrana data to niedziela (0 to niedziela)
                dataInput.value = ''; // Wyczyść pole daty, jeśli jest to niedziela
            }
        });

        // Dezaktywuj niedzielę jako opcję daty
        dataInput.addEventListener('click', function () {
            var selectedDate = new Date(dataInput.value);
            if (selectedDate.getDay() === 0) { // 0 to niedziela
                dataInput.value = ''; // Wyczyść pole daty, jeśli jest to niedziela
            }
        });
    });
</script>

                    <div class="form-group">
                        <label for="godzina">Godzina:</label>
                        <select class="form-control" name="godzina" required>
                            <option value="">Wybierz godzinę</option>
                            @for ($hour = 8; $hour <= 20; $hour++)
                                @for ($minute = 0; $minute < 60; $minute += 30)
                                    @php
                                        $formattedHour = str_pad($hour, 2, '0', STR_PAD_LEFT);
                                        $formattedMinute = str_pad($minute, 2, '0', STR_PAD_LEFT);
                                        $time = "{$formattedHour}:{$formattedMinute}";
                                    @endphp
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endfor
                            @endfor
                        </select>
                    </div>
                   <div class="form-group">
    <label for="rodzaj">Rodzaj wizyty:</label>
    <select class="form-control" name="rodzaj" id="rodzaj" required>
        <option value="" data-cena="0">--------</option>
        <option value="Strzyżenie Zwykłe" data-cena="60">Strzyżenie Zwykłe - 60 zł</option>
        <option value="Modelowanie" data-cena="50">Modelowanie - 50 zł</option>
        <option value="Koloryzacja" data-cena="180">Koloryzacja - 180 zł</option>
        <option value="Balejaż" data-cena="190">Balejaż - 190 zł</option>
        <option value="Ombre" data-cena="165">Ombre - 165 zł</option>
        <option value="Demakijaż+Kolor" data-cena="260">Demakijaż+Kolor - 260 zł</option>
        <option value="Trwała" data-cena="150">Trwała - 150 zł</option>
        <option value="Loki" data-cena="120">Loki - 120 zł</option>
        <option value="Grzywka" data-cena="30">Grzywka - 30 zł</option>
        <option value="Upięcia" data-cena="140">Upięcia - 140 zł</option>

    </select>
</div>
<input type="hidden" name="cena" id="cena" value="0">

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
                timeFormat: 'H:mm'
            });

            calendar.render();
        });
    </script>

    <style>
        .calendar-container {
            width: 75%;
        }
    </style>
@endsection
