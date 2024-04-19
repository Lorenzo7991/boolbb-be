@extends('layouts.app')


@section('title', 'Appartamenti')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-center">Appartamenti</h1>
        <!--Bottone per andare alla pagina di creazione appartamento-->
        <a class="btn btn-success text-align-center" href="{{ route('apartments.create') }}">Aggiungi appartamento</a>
    </div>

    <table class="table mt-4">
        <thead>
            <!--Colonne tabella-->
            <tr class="text-center">
                <th scope="col">Titolo</th>
                <th scope="col">Indirizzo</th>
                <th scope="col">Immagine</th>
                <th scope="col">Camere</th>
                <th scope="col">Letti</th>
                <th scope="col">Bagni</th>
                <th scope="col">Metri Quadri</th>
                <th scope="col">Publica</th>
                <th scope="col">Data creazione</th>
                <th class="text-center" scope="col">Console</th>
            </tr>
        </thead>
        <!--ciclo per girare sugli appartamenti e prendere i dettagli del singolo appartamento-->
        @foreach ($apartments as $apartment)
            <tbody>
                <tr class="text-center">
                    <!--Titolo appartemento-->
                    <td scope="row">{{ $apartment->title }}</td>

                    <!--Indirizzo appartemento-->
                    <td>{{ $apartment->address }}</td>

                    <!--Immagine appartamento-->
                    <td>
                        <figure class="index-figure">
                            <img style="width: 50px" src="{{ asset('storage/' . $apartment->image) }}"
                                class="img-fluid rounded" alt="{{ $apartment->title }}">
                        </figure>
                    </td>
                    <!--Camere appartemento-->
                    <td>{{ $apartment->rooms }}</td>
                    <!--Letti appartemento-->
                    <td>{{ $apartment->beds }}</td>
                    <!--Bagni appartemento-->
                    <td>{{ $apartment->bathrooms }}</td>
                    <!--Metri quadri appartemento-->
                    <td>{{ $apartment->square_meters }}</td>
                    <!--Visibilità appartamento-->
                    <td>
                        <div class="form-check form-switch">
                            <form onclick="this.submit()" method="POST"
                                action="{{ route('apartment.toggle-visibility', $apartment->id) }}">
                                @method('PATCH')
                                @csrf
                                <input class="form-check-input" type="checkbox" role="switch"
                                    id="visibility-{{ $apartment->is_visible }}"
                                    @if ($apartment->is_visible) checked @endif>
                                <label class="form-check-label"
                                    for="visibility-{{ $apartment->is_visible }}">{{ $apartment->is_visible ? 'Si' : 'No' }}</label>

                            </form>
                        </div>
                    </td>
                    <!--Data creazione appartemento-->
                    <td>{{ $apartment->getFormattedDate('created_at') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <!--Bottone dettaglio-->
                            <a href="{{ route('apartments.show', $apartment->id) }}" class="btn btn-primary"><i
                                    class="fa-solid fa-magnifying-glass"></i></a>
                            <!--Bottone modifica-->
                            <a class="btn btn-warning" href="{{ route('apartments.edit', $apartment->id) }}"><i
                                    class="fa-solid fa-pen-to-square text-white"></i></a>
                            <!--Bottone cancella-->
                            <form id="delete-form" action="{{ route('apartments.destroy', $apartment->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            </tbody>
        @endforeach
    </table>
@endsection
@section('scripts')
@endsection
