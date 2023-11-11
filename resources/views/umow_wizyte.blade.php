@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Wybierz usługę:</h1>
        <div class="row">
            @foreach($uslugi as $usluga)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $usluga->nazwa }}</h5>
                            <p class="card-text">Cena: {{ $usluga->cena }} zł</p>
                            <p class="card-text">Czas trwania: {{ $usluga->czas_trwania }} minut</p>
                            <div class="form-group">
                                <label for="pracownik_{{ $usluga->id }}">Wybierz pracownika:</label>
                                <select name="pracownik_{{ $usluga->id }}" id="pracownik_{{ $usluga->id }}" class="form-control">
                                 
                                    @foreach($fryzjerzy as $fryzjer)
                                        <option value="{{ $fryzjer->id }}">{{ $fryzjer->imie }} {{ $fryzjer->nazwisko }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="#" id="wybierzBtn-{{ $usluga->id }}" class="btn btn-primary btn-block">Wybierz</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @foreach($uslugi as $usluga)
                document.getElementById("wybierzBtn-{{ $usluga->id }}").addEventListener("click", function() {
                    var selectedPracownik = document.getElementById("pracownik_{{ $usluga->id }}").value;
                    var url = "{{ route('calendar', ['usluga' => $usluga, 'pracownik' => 'selectedPracownik']) }}".replace('selectedPracownik', selectedPracownik);
                    window.location.href = url;
                });
            @endforeach
        });
    </script>
</body>

</html>
@endsection
