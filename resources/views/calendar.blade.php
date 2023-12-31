@extends('layouts.app')

@section('content')
<meta charset='utf-8' />
<meta name='viewport' content='width=device-width, initial-scale=1' />
<title>Kalendarz</title>
<style>
    html body {
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
        width: 300px;
        padding: 10px;
        border: 1px solid #ccc;
        margin-top: 100px;
    }

    #time-picker select {
        width: 100%;
        padding: 5px;
    }

    #time-picker button {
        width: 100%;
        margin-top: 10px;
    }
    #selectedTimeDisplay {
        margin-top: 20px;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

<div class="container">
    <div id='calendar'></div>

    <div id='time-picker'>
        <h3>Wybierz datę z kalendarza:</h3>
        <p id="selectedDate">Wybrana data:</p>
        <p><span id="displayedDate"></span></p>
        <h3>Wybierz dostępną godzinę:</h3>
        <select id="freeTime" name="time">
            <option value="" selected disabled hidden>Wybierz godzinę</option>
        </select>
        <p id="selectedTimeDisplay">Wybrana godzina:</p>
        <form action="{{ route('zatwierdz') }}" method="POST">
            @csrf
            <input type="hidden" name="selectedTime" id="selectedTimeInput">
            <div>
                <button id="confirmTime" type="submit" class="btn btn-primary">Zatwierdź</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var today = new Date();

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialDate: today,
            firstDay: today.getDay(),
            selectable: true,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },

            validRange: {
                start: today,
            },
            dateClick: function(info) {
                var selectedDate = info.dateStr;
                document.getElementById('displayedDate').textContent = selectedDate;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/time-options/' + selectedDate,
                    type: 'GET',
                    success: function(response) {
                        var timeOptions = response.timeOptions;
                        var freeTimeSelect = document.getElementById('freeTime');
                        freeTimeSelect.innerHTML = '';

                        var defaultOption = document.createElement('option');
                        defaultOption.value = "";
                        defaultOption.textContent = "";
                        defaultOption.selected = true;
                        defaultOption.disabled = true;
                        defaultOption.hidden = true;
                        freeTimeSelect.appendChild(defaultOption);

                        for (var value in timeOptions) {
                            var option = document.createElement('option');
                            option.value = value;
                            option.textContent = timeOptions[value];
                            freeTimeSelect.appendChild(option);
                        }

                        if (freeTimeSelect.options.length > 1) {
                            freeTimeSelect.options[1].selected = true;
                            document.getElementById('selectedTimeDisplay').textContent = 'Wybrana godzina: ' + freeTimeSelect.options[1].textContent;
                            document.getElementById('selectedTimeInput').value = freeTimeSelect.options[1].textContent;
                        }
                    }
                });
            }
        });

        calendar.render();

        document.getElementById('freeTime').addEventListener('change', function() {
            var selectedTime = this.options[this.selectedIndex].text;
            if (selectedTime !== "Wybierz godzinę") {
                document.getElementById('selectedTimeDisplay').textContent = 'Wybrana godzina: ' + selectedTime;
                document.getElementById('selectedTimeInput').value = selectedTime;
            } else {
                document.getElementById('selectedTimeDisplay').textContent = '';
                document.getElementById('selectedTimeInput').value = '';
            }
        });

        document.getElementById('confirmTime').addEventListener('click', function(event) {
            var selectedTime = document.getElementById('freeTime').value;
            var selectedDate = document.getElementById('displayedDate').textContent;

            if (selectedDate === "" || selectedTime === "") {
                event.preventDefault();
                alert('Proszę wybrać datę i godzinę.');
            } else {
                console.log('Zatwierdzona godzina: ' + selectedTime);
                // Tutaj możesz dodać logikę przetwarzania wybranej godziny
            }
        });
    });
</script>

<!-- Cloudflare Pages Analytics -->
<script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "dc4641f860664c6e824b093274f50291"}'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
</body>
</html>
@endsection
