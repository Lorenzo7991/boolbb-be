@extends('layouts.app')


@section('title', 'Appartamenti')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-center">Appartamenti</h1>
        <!--Bottone per andare alla pagina di creazione appartamento-->
        <a class="btn btn-success text-align-center" href="{{ route('apartments.create') }}">Aggiungi appartamento</a>
    </div>

    {{-- @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif --}}

    <table class="table mt-4">
        <thead>
            <!--Colonne tabella-->
            <tr class="">
                <th scope="col" class="text-center"><i class=" ps-1 fa-solid fa-camera-retro fs-4"></i></th>
                <th scope="col">Titolo</th>
                <th scope="col">Indirizzo <i class="fa-solid fa-location-dot text-danger "></i></th>
                <th scope="col">Metri <i class="fa-solid fa-expand"></i></th>
                <th scope="col"><i class="fa-solid fa-coins text-warning "></i>/notte</th>
                <th scope="col">Publica</th>
                <th class="text-center" scope="col"><i class="fa-solid fa-gamepad fs-3 "></i></th>
            </tr>
        </thead>
        <!--ciclo per girare sugli appartamenti e prendere i dettagli del singolo appartamento-->
        @foreach ($apartments as $apartment)
            <tbody>
                <tr class="">
                    <!--Immagine appartamento-->
                    <td class="d-flex justify-content-center ">
                        <figure class="index-figure">
                            <img style="width: 50px" src="{{ asset('storage/' . $apartment->image) }}"
                                class="img-fluid rounded" alt="{{ $apartment->title }}">
                        </figure>
                    </td>

                    <!--Titolo appartemento-->
                    <td scope="row">{{ $apartment->title }}</td>

                    <!--Indirizzo appartemento-->
                    <td>{{ $apartment->address }}</td>

                    <!--Metri quadri appartemento-->
                    <td>{{ $apartment->square_meters }}</td>

                    <!--Prezzp per notte -->
                    <td>{{ $apartment->price_per_night }}</td>

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
                                <label class="form-check-label" for="visibility-{{ $apartment->is_visible }}"><i
                                        class="fa-solid  text-secondary {{ $apartment->is_visible ? 'fa-eye' : 'fa-eye-slash' }} "></i></label>

                            </form>
                        </div>
                    </td>

                    {{-- Bottoni --}}
                    <td>
                        <div class="d-flex justify-content-center  gap-2">
                            <!--Bottone dettaglio-->
                            <a href="{{ route('apartments.show', $apartment->id) }}" class="btn btn-primary"><i
                                    class="fa-solid fa-magnifying-glass"></i></a>
                            <!--Bottone modifica-->
                            <a class="btn btn-warning" href="{{ route('apartments.edit', $apartment->id) }}"><i
                                    class="fa-solid fa-pen-to-square text-white"></i></a>
                            <!--Bottone cancella-->
                            <form id="delete-form-{{ $apartment->id }}"
                                action="{{ route('apartments.destroy', $apartment->id) }}" method="POST"
                                class="delete-form" data-bs-toggle="modal" data-bs-target="#delete-modal">
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

    {{-- Paginazione --}}
    @if ($apartments->hasPages())
        {{ $apartments->links() }}
    @endif

    <!-- Modale Eliminazione -->
    @include('includes.delete_modal')
@endsection
@section('script')
    @vite('resources/js/delete_confirmation.js')
@endsection
