<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administracyjny - MatrasHair</title>
    <!-- Dodaj Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
           background: url('{{ asset('back.jpg') }}') no-repeat center center fixed;
           background-size: cover;
        }
        #wrapper {
            display: flex;
            height: 100vh;
        }
       #sidebar-wrapper {
    min-width: 250px;
    background: #495057; /* Ciemniejszy kolor tła dla lepszego kontrastu */
    color: #ffffff; /* Biały kolor tekstu */
}

.sidebar-heading {
    padding: 0.875rem 1.25rem;
    font-size: 1.2em;
    font-weight: bold;
    background: #343a40; /* Jeszcze ciemniejszy kolor dla nagłówka */
    color: #ffffff; /* Biały kolor tekstu dla nagłówka */
    margin-bottom: 1rem;
}

.list-group-item-action {
    color: #adb5bd; /* Jasnoszary kolor tekstu dla lepszej widoczności */
    border: none;
    padding: 0.75rem 1.25rem;
    background: transparent; /* Tło transparentne dla elementów listy */
}

.list-group-item-action:hover, .list-group-item-action:focus {
    color: #ffffff; /* Biały kolor tekstu dla hover */
    background-color: #6c757d; /* Jasniejszy kolor tła dla hover */
}
        #page-content-wrapper {
            flex: 1;
            padding: 10px;
            overflow-y: hidden;
            
        }
        .navbar {
            padding: 0.5rem 1rem;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e3e4e8;
        }
        .navbar-brand {
            font-weight: bold;
            color: #343a40;
        }
        /* Styl dla rozwijanego menu użytkownika */
        .user-menu {
            cursor: pointer;
        }
        .user-menu:hover {
            background-color: #e2e6ea;
        }
        #calendar {
            max-width: 700px; /* Maksymalna szerokość kalendarza */
            margin: 10px auto; /* Wycentruj kalendarz i dodaj margines na górze i na dole */
            background-color: #ffffff; /* Ustaw białe tło dla kalendarza */
            padding: 10px; /* Dodaj padding do kalendarza */
            /* Dodaj subtelne obramowanie */
            box-shadow: 0 0 10px rgba(0,0,0,0.15); /* Dodaj lekki cień dla głębi */
        }
    </style>
    </style>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">MatrasHair</a>
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


    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading">Panel Administracyjny</div>
            <h5 class="mt-2" style="padding-left: 20px;">Witaj, {{ Auth::user()->name }}</h5>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.zarzadzaj-grafikami') }}" class="list-group-item list-group-item-action">Zarządzaj grafikami</a>
                <a href="{{ route('admin.zarzadzaj-sklepem') }}" class="list-group-item list-group-item-action">Zarządzaj sklepem</a>
                <a href="{{ route('grafik-fryzjera') }}" class="list-group-item list-group-item-action">Mój grafik</a>
                <a href="{{ route('lista-klientow') }}" class="list-group-item list-group-item-action">Lista klientów</a>

                
                <a href="#" class="list-group-item list-group-item-action">Statystyki</a>
                
                <!-- Dodaj więcej linków według potrzeb -->
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
    <div class="container-fluid">
        <h4 class="mt-2">Mój kalendarz:</h4>
        <div id='calendar'></div> <!-- Kontener na kalendarz -->
    </div>
</div>    
        <div id='calendar'></div> <!-- Tutaj kalendarz zostanie wyrenderowany -->
    </div>
</div>

<script defer src='https://static.cloudflareinsights.com/beacon.min.js' data-cf-beacon='{"token": "dc4641f860664c6e824b093274f50291"}'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
<script>


document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    timeZone: 'local',
    initialView: 'timeGridWeek',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'timeGridWeek,timeGridDay'
    },
    allDaySlot: false, // To wyłącza pasmo "all-day"
    events: '/admin/reservations', // Endpoint API z wydarzeniami
    eventContent: function(arg) { // Niestandardowe renderowanie treści wydarzenia
      let contentEl = document.createElement('div');
      contentEl.innerHTML = arg.event.title;
      return { domNodes: [contentEl] };
    },
    eventDidMount: function(info) { // Dodawanie tooltipów
      $(info.el).tooltip({
        title: info.event.title,
        placement: 'top',
        trigger: 'hover',
        container: 'body'
      });
    }
  });

  calendar.render();
});

</script>

