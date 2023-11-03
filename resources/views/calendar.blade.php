@extends('layouts.app')

@section('content')
    <meta charset='utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1' />
    <title>Kalendarz</title>
    <style>
    <html>
    body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }

        .container {
            display: flex;
        }

        #calendar {
            width: 800px !important;
            margin: 40px 20px 0 20px;
        }

        #time-picker {
            width: 200px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        #time-picker select {
            width: 100%;
            padding: 5px;
        }

        #time-picker button {
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div id='calendar'></div>

        <div id='time-picker'>
        <h3>Wybierz datę z kalendarza:</h3>
        <p id="selectedDate">Wybrana data:</p>
        <p><span id="displayedDate"></span></p>
            <h3>Wybierz godzinę:</h3>
            <select id="freeTime" name="time">
    @foreach($timeOptions as $value => $label)
        <option value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select>
            <button id="selectTime" class="btn btn-primary">Wybierz</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var timePickerEl = document.getElementById('time-picker');
            var selectTimeButton = document.getElementById('selectTime');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

               dateClick: function(info) {
    //var chooseTime = info.dateStr; // Pobierz datę z kliknięcia

    // Aktualizuj wyświetlaną datę
    //document.getElementById('displayedDate').textContent = chooseTime;
    $wybierzDate=info.dateStr;
    document.getElementById('displayedDate').textContent = $wybierzDate;
   

    // Możesz także przekazać wybraną datę do kontrolera lub innych operacji tutaj
}
            });

            calendar.render();

            selectTimeButton.addEventListener('click', function() {
                var selectedTime = document.getElementById('chooseTime').value;
                // Tutaj możesz obsłużyć wybraną godzinę, np. zapisując ją w zmiennej lub wysyłając na serwer
                console.log('Wybrana godzina: ' + selectedTime);
            });
        });
    </script>

    <!-- Cloudflare Pages Analytics -->
    <script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "dc4641f860664c6e824b093274f50291"}'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
</body>
</html>
@endsection
