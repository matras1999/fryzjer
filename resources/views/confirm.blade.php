@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Potwierdzenie Rezerwacji</h1>
        
       <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Imię i Nazwisko Klienta</th>
            <th>Data Wizyty</th>
            <th>Telefon Klienta</th>
            <th>Usługa</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->imie_klienta }}</td>
                <td>{{ $reservation->data }}</td>
                <td>{{ $reservation->telefon_klienta }}</td>
                <td>{{ $reservation->rodzaj }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

        
        <a href="{{ route('home') }}" class="btn btn-primary">Powrót do Kalendarza</a>
    </div>
@endsection
