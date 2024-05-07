@extends('layouts.app')

@section('title', $apartment->title)

{{-- Sezione per includere CDNS fontAwsome --}}
@section('cdns')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous">

    <link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet">
@endsection

@section('content')

    <div>
        <div class="row justify-content-center">
            <div class="col-10 py-2">

                {{-- TITOLO APPARTAMENTO --}}
                <div class="card-header fs-1 mb-2"><strong>{{ $apartment->title }}</strong></div>
                <div class="row row-gap-3 infos">
                    <p class="col-12 col-sm-7 col-md-6 "><strong>Indirizzo:</strong> {{ $apartment->address }}</p>
                    {{-- STATO PUBBLICAZIONE --}}
                    <p class="col-12 col-sm-5 col-md-3"><strong>Pubblicato:</strong>
                        {!! $apartment->is_visible
                            ? '<i class="fa-solid fa-circle-check text-success "></i>'
                            : '<i class="fa-solid fa-circle-xmark text-danger "></i>' !!}
                    </p> 
                    <p class="col-12 col-md-3"><strong>Prezzo/n:</strong> {{ $apartment->price_per_night }}€</p>
                </div>
                <div class="row">
                    {{-- Sponsorizzazione --}}
                    @if ($latest_expiration_string !== null)
                        <div class="col-12 col-md-10 col-xl-8 col-xxl-6 my-3">
                            <a class="card text-decoration-none sponsorship-button"
                                href="{{ route('sponsorship.create', $apartment->id) }}">
                                <div class="card-header text-center sponsor-btn ">
                                    <i class="text-warning fa-solid fa-bolt-lightning"></i> Estendi sponsorizzazione
                                </div>
                                <div class="card-body" id="counter"
                                    data-expiration-date="{{ $latest_expiration_string }}">
                                    <div class="d-flex justify-content-between column-gap-3 ">
                                        {{-- Giorni --}}
                                        <div class="d-flex flex-column align-items-center border rounded w-25 ">
                                            <span class="text-nowrap" id="days"></span>
                                            <small class="d-none d-sm-inline">Giorni</small>
                                            <small class="d-sm-none">G</small>
                                        </div>
                                        {{-- Ore --}}
                                        <div class="d-flex flex-column align-items-center border rounded w-25  ">
                                            <span class="text-nowrap" id="hours"></span>
                                            <small class="d-none d-sm-inline">Ore</small>
                                            <small class="d-sm-none">O</small>
                                        </div>
                                        {{-- Minuti --}}
                                        <div class="d-flex flex-column align-items-center border rounded w-25 ">
                                            <span class="text-nowrap" id="minutes"></span>
                                            <small class="d-none d-sm-inline">Minuti</small>
                                            <small class="d-sm-none">M</small>
                                        </div>
                                        {{-- Secondi --}}
                                        <div class="d-flex flex-column align-items-center border rounded w-25 ">
                                            <span class="text-nowrap" id="seconds"></span>
                                            <small class="d-none d-sm-inline">Secondi</small>
                                            <small class="d-sm-none">S</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-sm sponsorship-button my-3"
                                href="{{ route('sponsorship.create', $apartment->id) }}">
                                <i class="text-warning fa-solid fa-bolt-lightning me-1"></i> Sponsorizza
                            </a>
                        </div>
                    @endif

                </div>
                <div class="row">
                    <div class="col-12">

                        {{-- IMMAGINE PRINCIPALE --}}
                        <img src="{{ asset('storage/' . $apartment->image) }}" class="img-fluid show-main-img mb-3"
                            alt="{{ $apartment->title }}">
                        <div class="d-flex justify-content-start">
                            <form id="add-image" class="d-none" action="{{ route('image.store', $apartment->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="image"
                                    class="form-control  @error('image') is-invalid @elseif(old('image', '')) is-valid @enderror"
                                    id="add-secondary-image">
                            </form>
                            <button id="add-img-btn" type="button" class="btn btn-sm btn-primary sponsor-cs-color mb-3 p-2"><i
                                    class="fas fa-plus"></i> Immagine</button>
                        </div>
                        {{-- GALLERIA IMMAGINI --}}
                        <ul class="d-flex list-unstyled col-12 row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xxl-4 mt-4"> 
                            @foreach ($apartment->images as $image)
                                <li class="gallery-item col">
                                    <figure class="show-figure">
                                        <img src="{{ asset('storage/' . $image->path) }}" class="rounded img-fluid"
                                            alt="image-{{ $image->id }}">
                                    </figure>
                                    <form class="delete-img" action="{{ route('image.destroy', $image->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class=" btn-sm btn delete-img-btn" type="submit"><i
                                                class="text-white fa-solid fa-xmark"></i></button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col">
                        {{-- descrizione dell'appartamento --}}
                        <h4><strong>Descrizione</strong></h4>
                        <p>{{ $apartment->description }}</p>

                        {{-- gruppo informazioni stanze, letti e bagni ecc... --}}
                        <div id="services" class="align-items-center gap-3 d-flex">
                            <p><i class="fa-solid fa-house me-2"></i><strong>Stanze:</strong>
                                {{ $apartment->rooms }}</p>
                            <p><i class="fa-solid fa-bed me-2"></i><strong>Letti:</strong> {{ $apartment->beds }}
                            </p>
                            <p><i class="fa-solid fa-toilet me-2"></i><strong>Bagni:</strong>
                                {{ $apartment->bathrooms }}</p>
                            <p><i class="fa-solid fa-ruler me-2"></i><strong>Metri quadrati:</strong>
                                {{ $apartment->square_meters }}mq</p>
                        </div>
                        <div>
                            {{-- SERVIZI --}}
                            <h5 class="my-4"><strong>Servizi</strong></h5>
                            <ul class="d-flex list-unstyled gap-4 ms-2">
                                @foreach ($apartment->services as $service)
                                    <li>
                                        <i class="{{ $service->icon }} fs-4"></i>
                                    </li>
                                @endforeach
                            </ul>
                        </div> 
                        
                        <hr class="my-5">

                        {{-- Mappa --}}
                        <h4><strong>Mappa</strong></h4>
                        <div id="map" class="rounded-4 my-4" style="width: 100%; height: 350px;"></div>
                    </div>
                </div>

                <hr class="my-5">

                {{-- Grafico visualizzazioni --}}

                <h4><strong>Grafico visualizzazioni</strong></h4>
                <div id="graph-container" class="container pt-4">
                    <canvas data-views="{{ $apartment->views }}" id="myChart"></canvas>
                </div>


                <div id="btn-group-action " class=" my-4 card-footer d-flex align-items-center justify-content-end gap-3">
                    {{-- Gruppo pulsanti navigazione --}}
                    {{-- Gruppo pulsanti azione --}}
                    {{-- Pulsante modifica --}}
                    <a href="{{ route('apartments.edit', $apartment->id) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pencil me-2"></i>{{ __('Modifica') }}</a>
                    {{-- Form(pulsante) eliminazione --}}
                    <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST" class="delete-form"
                        data-bs-toggle="modal" data-bs-target="#delete-modal" data-title="{{ $apartment->title }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash-can me-2"></i>{{ __('Elimina') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modale Eliminazione -->
    @include('includes.delete_modal')
@endsection
@section('script')
    @vite('resources/js/sponsorship_countdown.js')
    @vite('resources/js/delete_confirmation.js')
    @vite('resources/js/secondary_images.js')
    @vite('resources/js/views_graph.js')



    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.0.0/maps/maps-web.min.js"></script>

    <script>
        var map = tt.map({
            key: 'AWAhF6IT1ChO0k28GMmsIysmnTgt0Gpp',
            container: 'map',
            center: [{!! $apartment->longitude !!}, {!! $apartment->latitude !!}],
            zoom: 15 // Livello di zoom della mappa
        });

        // Aggiungi un marker per le tue coordinate
        var marker = new tt.Marker().setLngLat([{!! $apartment->longitude !!}, {!! $apartment->latitude !!}]).addTo(map);
    </script>
@endsection
