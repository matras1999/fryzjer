@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Statystyki Salonu Fryzjerskiego MatrasHair</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>Grudzień 2023</h2>
                </div>
                <div class="card-body">
                    <p>Liczba wizyt: 120</p>
                    <p>Liczba klientów obsłużonych przez Łukasza Kowalskiego: 40</p>
                    <p>Liczba klientów obsłużonych przez Jana Nowaka: 50</p>
                    <p>Liczba klientów obsłużonych przez Katarzynę Pach: 30</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>Przesuń między miesiącami</h2>
                </div>
                <div class="card-body">
                    <div class="btn-group" role="group">
                        <button class="btn btn-primary">Październik</button>
                        <button class="btn btn-primary">Listopad</button>
                        <button class="btn btn-primary">Styczeń</button>
                        <!-- Dodaj przyciski dla innych miesięcy -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
