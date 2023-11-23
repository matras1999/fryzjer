{{-- resources/views/zatwierdz.blade.php --}}

@extends('layouts.app') {{-- Załóżmy, że używasz standardowego layoutu --}}

@section('content')
<div class="container">
    <h2>Potwierdzenie Rezerwacji</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Imię i nazwisko</th>
                <th>Data</th>
                <th>Godzina</th>
                <th>Cena</th>
                <th>Imię pracownika</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $reservation)
                <tr>
                   
                    <td>{{ auth()->user()->name }}</td>
                    <td>{{ $reservation->data }}</td>
                    <td>{{ $reservation->godzina_od }}</td>
                    <td>{{ $reservation->usluga->cena }} zł</td> {{-- Zakładam, że cena jest w modelu usługi --}}
                    <td>{{ $reservation->fryzjer->imie }} {{ $reservation->fryzjer->nazwisko }}</td>

                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
