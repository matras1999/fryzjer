@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Terminarz wizyt</h1>
        <div class="row">
            <div class="col-md-7">
                <div id='calendar' style="width: 100%; height: 600px;"></div>
            </div>
            
            <div class="col-md-5">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Formularz rezerwacji</h2>
            <form method="POST" action="{{ route('zapiszWizyte') }}">
                @csrf
                <div class="form-group">
                    <label for="data">Data:</label>
                    <input type="date" name="data" required>
                </div>

                <div class="form-group">
                    <label for="godzina">Godzina:</label>
                    <select name="godzina" required>
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
                    <label for="usluga">Wybierz rodzaj usługi:</label>
                    <select name="usluga" required>
                        <option value="">Wybierz usługę</option>
                        @foreach($uslugi as $usluga)
                            <option value="{{ $usluga->id }}">
                                {{ $usluga->nazwa }} - {{ $usluga->cena }} zł ({{ $usluga->czas_trwania }} minut)
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Umów wizytę</button>
            </form>
        </div>
    </div>
</div>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css." />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script>
       document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',
        
        events: @json($reservations),
        timeZone: 'Europe/Warsaw',
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            omitZeroMinute: false,
            meridiem: 'narrow',
            display: 'inverse-background'
        },
        eventRender: function(info) {
            var startTime = info.event.start;
            var formattedTime = startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            info.el.querySelector('.fc-title').innerHTML = formattedTime + ' - ' + info.event.title;
        },
    });

    calendar.render();
});

    </script>
@endsection
