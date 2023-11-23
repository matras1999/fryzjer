@extends('layouts.app')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <!-- Styles -->

@section('content')
<div style="background-image: url('{{ asset('zdj4.jpg') }}'); background-size: cover; background-position: top left; width: 100vw; height: 100vh; background-repeat: no-repeat; display: flex; flex-direction: column; justify-content: flex-start; align-items: flex-start; position: relative;" </div>


    <div class="text-white py-5 px-10" style="text-align: center;"</div>
        <h1>Witaj w salonie fryzjerskim Migda Hair</h1>
        <p style="margin-bottom: 20px;">Zapraszamy do skorzystania z naszych usług.</p>
        <div style="display: flex; justify-content: center;">
            <a href="{{ route('umow_wizyte') }}" class="btn btn-primary" style="margin-right: 10px;"> Umów wizytę </a>
            <a href="{{ route('produkty') }}" class="btn btn-primary">Przejź do sklepu</a>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h2>Nasze Najnowsze Realizacje</h2>
    <div class="row">
        <div class="col-md-4">
            <img src="{{ asset('zdj2.jpg') }}" alt="Realizacja 1" class="img-fluid">
        </div>
        <div class="col-md-4">
            <img src="{{ asset('zdj3.jpg') }}" alt="Realizacja 2" class="img-fluid">
        </div>
        <div class="col-md-4">
            <img src="{{ asset('zdj1.jpg') }}" alt="Realizacja 3" class="img-fluid">
        </div>
    </div>
</div>

<div class="container mt-5">
    <h2>Nasze Nowe Produkty</h2>
    <!-- Tu możesz dodać treść dotyczącą produktów -->
</div>
@endsection
