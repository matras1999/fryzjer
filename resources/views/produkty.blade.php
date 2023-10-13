@extends('layouts.app')

@section('content')
    <h1>Potwierdzenie Rezerwacji</h1>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Data Wizyty</th>
                <th>Imię i Nazwisko Klienta</th>
                <th>Telefon Klienta</th>
                <th>Usługa</th>
            </tr>
        </thead>
        <tbody>
            <!-- To jest pusta tabela -->
        </tbody>
    </table>
    
    <a href="{{ route('home') }}">Powrót do Kalendarza</a>
</div>
@endsection
