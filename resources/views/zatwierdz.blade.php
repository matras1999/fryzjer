@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Potwierdzenie Rezerwacji</h2>

    @if($reservations->isEmpty())
        <p>Brak rezerwacji.</p>
        <a href="{{ route('umow_wizyte') }}" class="btn btn-primary">Umów wizytę</a>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Imię i nazwisko</th>
                    <th>Data</th>
                    <th>Godzina</th>
                    <th>Cena</th>
                    <th>Imię pracownika</th>
                    <th>Anuluj</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ auth()->user()->name }}</td>
                        <td>{{ $reservation->data }}</td>
                        <td>{{ $reservation->godzina_od }}</td>
                        <td>{{ $reservation->usluga->cena }} zł</td>
                        <td>{{ $reservation->fryzjer->imie }} {{ $reservation->fryzjer->nazwisko }}</td>
                        <td>
                            <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" onsubmit="return confirm('Czy na pewno chcesz anulować swoją rezerwację?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Anuluj rezerwację</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
