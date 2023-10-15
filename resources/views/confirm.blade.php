@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Potwierdzenie Rezerwacji</h1>
        
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Imię i Nazwisko Klienta</th>
                    <th>Data Wizyty</th>
                    <th>Godzina Wizyty</th>
                    <th>Telefon Klienta</th>
                    <th>Usługa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->imie_klienta }}</td>
                        <td>{{ $reservation->data }}</td>
                        <td>{{ $reservation->godzina }}</td>
                        <td>{{ Auth::user()->phone }}</td>
                        <td>{{ $reservation->rodzaj }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Dodaj ramkę i pogrubienie dla "Kwota do zapłaty" -->
        <div style="width: 18%; margin-left;">
            <div style="border: 2px solid #000; padding: 10px; font-weight: bold;">
                <p>Kwota do zapłaty: {{ $reservations->sum('cena') }} zł</p>
            </div>
        </div>
        
        <!-- Przyciski umieszczone niżej -->
        <div style="text-align: left; margin-top: 20px;">
            <a href="{{ route('umow_wizyte') }}" class="btn btn-primary">Kalendarz</a>
            <a href="{{ route('produkty') }}" class="btn btn-success">Przejdź do sklepu</a>
        </div>
    </div>
@endsection
