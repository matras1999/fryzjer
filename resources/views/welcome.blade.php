@extends('layouts.app')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<head>

    <style>
        /* Dodaj kolor tła */
        body {
            background-color: #f0f0f0;
        }

        .prawy-przycisk {
            float: right;
            margin-right: 10px;
        }

        .super-kadra {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 10px 0;
        }

        /* Dodaj efekt gradientu do przycisków */
        .btn-primary {
            background: linear-gradient(to bottom, #3498db, #2980b9);
            border: none;
        }

        /* Dodaj animację do przycisków */
        .btn-primary:hover {
            transform: scale(1.05);
            transition: transform 0.2s;
        }

        /* Dodaj styl dla animowanego napisu */
       #animowany-napis {

    font-size: 24px;
    font-weight: bold;
    color: white; /* Ukryj tekst */
    margin-top: 20px;
    overflow: hidden; /* Ukryj nadmiarowe litery */
    animation: fade-in-right 3s ease-in-out forwards; /* Animacja fade-in-right */
}
#animowany-zapraszamy {
    font-size: 18px;
    color: transparent; /* Ukryj tekst */
    margin-bottom: 20px;
    white-space: nowrap; /* Zapobiegaj zawijaniu tekstu */
    overflow: hidden; /* Ukryj nadmiarowe litery */
    animation: fade-in-right 3s ease-in-out 1s forwards; /* Animacja fade-in-right */
}
.animowany-przycisk {
    opacity: 0;
    animation: fade-in 1s ease-in-out forwards;
    transform-origin: center;
    animation-delay: 3.5s; /* Dodaj opóźnienie 0.5 sekundy */
}

/* Definicja animacji fade-in */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Definicja animacji fade-in-right */
@keyframes fade-in-right {
    from {
        opacity: 0;
        transform: translateX(100%); /* Przesunięcie z prawej strony */
    }
    to {
        opacity: 1;
        transform: translateX(0);
        color: white; /* Dodaj kolor tekstu po animacji */
    }

}
    </style>
</head>
@section('content')
<div style="background-image: url('{{ asset('zdj4.jpg') }}'); background-size: cover; background-position: width: 100vw; height: 100vh; background-repeat: no-repeat; display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; position: relative;">
 
        <!-- Dodaj animowany napis -->
        <h1 id="animowany-napis" style="margin-top: 50px; margin-left: 50px;">Witaj w salonie fryzjerskim Matras Hair</h1>
<p id="animowany-zapraszamy" style="margin-bottom: 20px; margin-left: 80px;">Zapraszamy do skorzystania z naszych usług.</p>
<div style="display: flex; justify-content: center; margin-left: 120px;">
        @if(auth()->check())
            <a href="{{ route('umow_wizyte') }}" class="btn btn-primary animowany-przycisk" style="margin-right: 10px;"> Umów wizytę </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary animowany-przycisk" style="margin-left: 10px;"> Umów wizytę </a>
        @endif
        <a href="{{ route('produkty') }}" class="btn btn-primary animowany-przycisk"  style="margin-left: 10px;">Przejdź do sklepu</a>
    </div>
    </div>
</div>

<!-- Pozostała część twojego kodu pozostaje bez zmian -->




<div class="container mt-5">
    <h2>Nasze Najnowsze Realizacje</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card" style="border: 2px solid #333;">
                <img src="{{ asset('zdj2.jpg') }}" alt="Realizacja 1" class="card-img-top img-fluid">
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="border: 2px solid #333;">
                <img src="{{ asset('zdj3.jpg') }}" alt="Realizacja 2" class="card-img-top img-fluid">
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="border: 2px solid #333;">
                <img src="{{ asset('zdj1.jpg') }}" alt="Realizacja 3" class="card-img-top img-fluid">
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h2>Poznaj naszych pracowników</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="border: 2px solid #333; overflow: hidden;">
                <img src="{{ asset('fryzjerzy.jpg') }}" alt="Nasi Fryzjerzy" class="card-img-top img-fluid" style="object-fit: cover; width: 100%; max-height: 650px;">
                <div class="card-body">
                    <a href="/kadra" class="btn btn-primary prawy-przycisk">Czytaj więcej</a>
                    <h5>Nasza kadra to doświadczeni fryzjerzy, którzy dbają o Twój wygląd. Każdy z nich jest ekspertem w swojej dziedzinie.</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <!-- Dodaj godziny pracy i numer telefonu kontaktowego z lepszym wyglądem -->
            <p style="font-size: 18px; font-weight: bold;">Godziny pracy salonu:</p>
            <p>Poniedziałek - Sobota</p>
            <p>8:00 - 16:00</p>
            <p style="font-size: 18px; font-weight: bold;">Numer telefonu kontaktowego:</p>
            <p>(123) 456-7890</p>
        </div>
    </div>
</div>


<div class="footer">
    &copy; Szymon Matras {{ date('Y') }}
</div>

@endsection
