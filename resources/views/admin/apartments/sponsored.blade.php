@extends('layouts.app')

@section('title', 'Appartamenti')

@section('content')
<div class="d-flex justify-content-between align-items-center text-center p-3">
    <h2 id="index-title" class="text-center home-title fs-1 fw-bolder">Sponsorizzazioni attive:</h2>
</div>
<table class="table shadow-lg rounded">
    <thead>
        <!-- Colonne tabella -->
        <tr class="text-center">
            <th scope="col" class="text-center text-white brd-left"><i
                    class="ps-1 fa-solid fa-camera-retro icon-border"></i></th>
            <th scope="col" class="text-white"><div class="d-flex justify-content-center align-items-center"><i class="fa-solid fa-tag me-2 icon-border"></i><span class="d-none d-xl-table-cell">Titolo</span></div></th>
            <th scope="col" class="text-white d-none d-md-table-cell"><div class="d-flex justify-content-center align-items-center"><i class="fa-solid fa-location-dot me-2 icon-border"></i><span class="d-none d-xl-table-cell">Indirizzo</span></div></th>
            <th scope="col" class="text-center text-white"><div class="d-flex justify-content-center align-items-center"><i class="fa-regular fa-clock me-2"></i><span class="d-none d-xl-table-cell">Scadenza sponsorizzazione</span></div></th>
            <th scope="col" class="text-white d-none d-md-table-cell">Publicati</th>
            <th class="text-center text-white brd-right" scope="col"><i class="fa-solid fa-gamepad icon-border"></i></th><span></span>
        </tr>
    </thead>
    <!-- Ciclo per iterare sugli appartamenti e prendere i dettagli del singolo appartamento -->
    @foreach ($sponsoredApartments as $apartment)
        <tbody>
            <tr class="text-center align-middle">
                <!-- Immagine appartamento -->
                <td class="justify-content-center ">
                    <div class="d-flex justify-content-center">
                    <figure class="index-figure">
                        <img src="{{ asset('storage/' . $apartment->image) }}"
                            class="img-fluid rounded" alt="{{ $apartment->title }}">
                    </figure>
                </div>
                </td>

                <!-- Titolo appartamento -->
                <td scope="row">{{ $apartment->title }}</td>

                <!-- Indirizzo appartamento -->
                <td class="d-none d-md-table-cell">{{ $apartment->address }}</td>

                <!-- Data di scadenza della sponsorizzazione -->
                <td class="text-center">
                    <span>
                    {{ \Carbon\Carbon::parse($apartment->expiration_date)->format('d-m-Y') }}
                </span>
                </td>

                <!-- Visibilità appartamento -->
                <td class="d-none d-md-table-cell">
                    <div class="form-switch">
                        <form onclick="this.submit()" method="POST"
                            action="{{ route('apartment.toggle-visibility', $apartment->id) }}">
                            @method('PATCH')
                            @csrf
                            <input class="form-check-input" type="checkbox" role="switch"
                                id="visibility-{{ $apartment->is_visible }}"
                                @if ($apartment->is_visible) checked @endif>
                            <label  class="form-check-label" for="visibility-{{ $apartment->is_visible }}"><i
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
                    </div>
                </td>
            </tr>
        </tbody>
    @endforeach
</table>
@endsection

@section('script')
@endsection
