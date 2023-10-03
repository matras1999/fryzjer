import './bootstrap';
import FullCalendar from '@fullcalendar/core';

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        // Inna konfiguracja kalendarza
    });
    calendar.render();
});
