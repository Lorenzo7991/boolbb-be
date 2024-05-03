@extends('layouts.app')

@section('title', 'Appartamenti')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h1 id="index-title" class="home-title text-center">I tuoi appartamenti con sponsorizzazione attiva:</h1>
</div>
<table class="table mt-4 shadow-lg p-3 mb-5 rounded">
    <thead>
        <!-- Colonne tabella -->
        <tr>
            <th scope="col" class="text-center text-white brd-left"><i
                    class="ps-1 fa-solid fa-camera-retro icon-border"></i></th>
            <th scope="col" class="text-white"><i class="fa-solid fa-tag me-2 icon-border"></i>Titolo</th>
            <th scope="col" class="text-white"><i class="fa-solid fa-location-dot me-2 icon-border"></i>Indirizzo</th>
            <th scope="col" class="text-center text-white"><i class="fa-regular fa-clock me-2"></i>Scadenza sponsorizzazione</th>
            <th scope="col" class="text-white">Publicati</th>
            <th class="text-center text-white brd-right" scope="col"><i class="fa-solid fa-gamepad icon-border"></i></th>
        </tr>
    </thead>
    <!-- Ciclo per iterare sugli appartamenti e prendere i dettagli del singolo appartamento -->
    @foreach ($sponsoredApartments as $apartment)
        <tbody>
            <tr class="">
                <!-- Immagine appartamento -->
                <td class="d-flex justify-content-center ">
                    <figure class="index-figure">
                        <img style="width: 50px" src="{{ asset('storage/' . $apartment->image) }}"
                            class="img-fluid rounded" alt="{{ $apartment->title }}">
                    </figure>
                </td>

                <!-- Titolo appartamento -->
                <td scope="row">{{ $apartment->title }}</td>

                <!-- Indirizzo appartamento -->
                <td>{{ $apartment->address }}</td>

                <!-- Data di scadenza della sponsorizzazione -->
                <td class="text-center">
                    {{ \Carbon\Carbon::parse($apartment->expiration_date)->format('d-m-Y H:i:s') }}
                </td>

                <!-- Visibilità appartamento -->
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
                                    class="fa-solid {{ $apartment->is_visible ? 'fa-eye text-primary' : 'fa-eye-slash text-secondary' }} "></i></label>

                        </form>
                    </div>
                </td>

                {{-- Bottoni --}}
                <td>
                    <div class="d-flex justify-content-center  gap-2">
                        <!-- Bottone dettaglio -->
                        <a href="{{ route('apartments.show', $apartment->id) }}" class="btn btn-primary"><i
                                class="fa-solid fa-magnifying-glass"></i></a>
                        <!-- Bottone modifica -->
                        <a class="btn btn-warning" href="{{ route('apartments.edit', $apartment->id) }}"><i
                                class="fa-solid fa-pen-to-square text-white"></i></a>
                        <!-- Bottone cancella -->
                        <form id="delete-form-{{ $apartment->id }}"
                            action="{{ route('apartments.destroy', $apartment->id) }}" method="POST"
                            class="delete-form" data-bs-toggle="modal" data-bs-target="#delete-modal"
                            data-title="{{ $apartment->title }}">
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

@section('script')
@endsection
