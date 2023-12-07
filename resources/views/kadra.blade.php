@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

        /* Stylizacja kadry */
        .kadrofryzjerow {
            display: flex;
            justify-content: center; /* To wyśrodkuje elementy */
            align-items: flex-start;
            padding: 10px;
            gap: 100px; /* Możesz kontrolować odstępy między dziećmi kontenera flex */
            background-color: #f0f0f0;
            margin-bottom: 50px;

        }

        /* Stylizacja zdjęcia */
        .zdjecie {
            width: 20%; /* Szerokość zdjęcia */
            text-align: center;
            border: 2px solid #333; /* Obramowanie */
            margin: 5px; /* Odstęp między zdjęciami w poziomie */
            padding: 0; /* Brak wewnętrznego paddingu */
            transition: transform 0.2s ease-in-out;
            overflow: hidden; /* Zabezpieczenie przed wystawaniem zdjęć poza obramowanie */
        }

        /* Maksymalny rozmiar zdjęcia wewnątrz .zdjecie */
        .zdjecie img {
            max-width: 100%; /* Zdjęcie nie będzie większe niż jego kontener */
            max-height: 100%; /* Zdjęcie nie będzie większe niż jego kontener */
            height: auto;
        }

        /* Hover - Powiększanie zdjęć */
        .zdjecie:hover {
            transform: scale(1.1);
        }

        /* Stylizacja opisu */
        .opis {
            font-size: 14px;
            margin-top: 5px;
            font-weight: bold;
        }

        /* Stylizacja długiego opisu */
        .dlugi-opis {
            font-size: 12px;
            margin-top: 3px;
        }

        /* Ciemny pasek na dole strony */
      
   .footer {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 10px 0;
        }

    </style>
</head>
<body>
<div class="kadrofryzjerow">
    <div class="zdjecie">
        <img src="lukasz.jpg" alt="Łukasz Kowalski">
        <p class="opis">Łukasz Kowalski</p>
        <p class="dlugi-opis">
            Łukasz Kowalski to nasz szef i doświadczony fryzjer. Jego pasją jest tworzenie nowoczesnych i unikalnych fryzur. Specjalizuje się w koloryzacji włosów i cięciach, dbając.
        </p>
        <p class="krotki-opis">Szef z pasją do fryzjerstwa.</p>
    </div>
    <div class="zdjecie">
        <img src="kasia.jpg" alt="Katarzyna Pach">
        <p class="opis">Katarzyna Pach</p>
        <p class="dlugi-opis">
            Katarzyna Pach to doświadczona fryzjerka, która ma za sobą wiele lat pracy w branży. Jej specjalnością są fryzury ślubne oraz upiększanie włosów.
        </p>
        <p class="krotki-opis">Doświadczona fryzjerka.</p>
    </div>
    <div class="zdjecie">
        <img src="janek.jpg" alt="Jan Nowak">
        <p class="opis">Jan Nowak</p>
        <p class="dlugi-opis">
            Jan Nowak to kreatywny fryzjer, który zawsze idzie na wietrze. Jego pasją jest eksperymentowanie z różnymi stylami i trendami.
        </p>
        <p class="krotki-opis">Kreatywny fryzjer.</p>
    </div>
</div>

<div class="footer">
    &copy; Szymon Matras {{ date('Y') }}
</div>
</body>
</html>

@endsection
