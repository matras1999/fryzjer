@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Statystyki Salonu Fryzjerskiego MatrasHair</h1>
    
    <div class="row">
        <div class="col-md-4">
            <h2>Grudzień 2023</h2>
            <p>Liczba wizyt: 120</p>
            <p>Liczba klientów obsłużonych przez Łukasza Kowalskiego: 40</p>
            <p>Liczba klientów obsłużonych przez Jana Nowaka: 50</p>
            <p>Liczba klientów obsłużonych przez Katarzynę Pach: 30</p>
        </div>
        
       <div class="col-md-4">
            <h2>Przesuń między miesiącami</h2>
            <button class="btn btn-primary">Styczeń</button>
            <button class="btn btn-primary">Luty</button>
            <button class="btn btn-primary">Marzec</button>
            <!-- Dodaj przyciski dla innych miesięcy -->
        </div>
    </div>
</div>
@endsection
