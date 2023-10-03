@extends('layouts.app')

@section('content')
    <div class="container">
    @if(\Session::has('message')))
        <div class="row">
            <div class="col-12 text-white bg-success">
                {{ \Session::get('message') }}
            </div>
        </div>
    @endif
        <div class="row">
            <div class="col-md-6">
                <h2>Kalendarz</h2>
                <div id='calendar'></div>
            </div>
            <div class="col-md-6">
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
                events: @json($reservations)
            });

            calendar.render();
        });
    </script>
@endsection
