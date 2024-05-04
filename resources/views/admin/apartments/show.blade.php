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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">

                    {{-- TITOLO APPARTAMENTO --}}
                    <div class="card-header fs-3"><strong>{{ $apartment->title }}</strong></div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">

                                {{-- IMMAGINE PRINCIPALE --}}
                                <img src="{{ asset('storage/' . $apartment->image) }}" class="img-fluid show-main-img"
                                    alt="{{ $apartment->title }}">
                            </div>
                            <div class="col-md-6">

                                {{-- descrizione dell'appartamento --}}
                                <p><strong>Descrizione:</strong> {{ $apartment->description }}</p>

                                {{-- gruppo informazioni stanze, letti e bagni ecc... --}}
                                <div id="services" class="d-flex align-items-center gap-3">
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
                                    <h5>Servizi:</h3>
                                        <ul class="d-flex list-unstyled gap-4">
                                            @foreach ($apartment->services as $service)
                                                <li>
                                                    <img style="width: 25px" src="{{ $service->icon }}"
                                                        alt="{{ $service->label }}">
                                                </li>
                                            @endforeach
                                        </ul>
                                </div>
                                {{-- INDIRIZZO - LAT - LON --}}
                                <p><strong>Indirizzo:</strong> {{ $apartment->address }}</p>
                                <p><strong>Prezzo/n:</strong> {{ $apartment->price_per_night }}€</p>

                                {{-- Mappa --}}
                                <div id="map" style="width: 100%; height: 400px;"></div>


                                {{-- STATO PUBBLICAZIONE --}}
                                <p><strong>Pubblicato:</strong>
                                    {!! $apartment->is_visible
                                        ? '<i class="fa-solid fa-circle-check text-success "></i>'
                                        : '<i class="fa-solid fa-circle-xmark text-danger "></i>' !!}
                                </p>
                                {{-- INSERIMENTO IMMAGINI AGGIUNTIVE --}}
                                <div class="row">
                                    <div class="col-3">
                                        <form id="add-image" class="d-none"
                                            action="{{ route('image.store', $apartment->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="image"
                                                class="form-control  @error('image') is-invalid @elseif(old('image', '')) is-valid @enderror"
                                                id="add-secondary-image">
                                        </form>
                                        <button id="add-img-btn" type="button" class="btn btn-sm btn-primary mb-3"><i
                                                class="fas fa-plus"></i> Immagine</button>
                                    </div>
                                    {{-- Sponsorizzazione --}}
                                    @if ($latest_expiration_string !== null)
                                        <div class="col-9">
                                            <a class="card text-decoration-none sponsorship-button"
                                                href="{{ route('sponsorship.create', $apartment->id) }}">
                                                <div class="card-header text-center ">
                                                    <i class="fa-solid fa-bolt-lightning"></i> Estendi
                                                </div>
                                                <div class="card-body" id="counter"
                                                    data-expiration-date="{{ $latest_expiration_string }}">
                                                    <div class="d-flex justify-content-between column-gap-3 ">
                                                        {{-- Giorni --}}
                                                        <div
                                                            class="d-flex flex-column align-items-center border rounded w-25 ">
                                                            <span class="text-nowrap" id="days"></span>
                                                            <small>Giorni</small>
                                                        </div>
                                                        {{-- Ore --}}
                                                        <div
                                                            class="d-flex flex-column align-items-center border rounded w-25  ">
                                                            <span class="text-nowrap" id="hours"></span>
                                                            <small>Ore</small>
                                                        </div>
                                                        {{-- Minuti --}}
                                                        <div
                                                            class="d-flex flex-column align-items-center border rounded w-25 ">
                                                            <span class="text-nowrap" id="minutes"></span>
                                                            <small>Minuti</small>
                                                        </div>
                                                        {{-- Secondi --}}
                                                        <div
                                                            class="d-flex flex-column align-items-center border rounded w-25 ">
                                                            <span class="text-nowrap" id="seconds"></span>
                                                            <small>Secondi</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @else
                                        <div class="col-4">
                                            <a class="btn btn-sm sponsorship-button"
                                                href="{{ route('sponsorship.create', $apartment->id) }}">
                                                <i class="fa-solid fa-bolt-lightning"></i> Metti in evidenza
                                            </a>
                                        </div>
                                    @endif

                                </div>
                            </div>

                            {{-- GALLERIA IMMAGINI --}}
                            <ul class="d-flex list-unstyled col-12 row row-cols-2 row-cols-lg-3 row-cols-xxl-4 mt-4">
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
                    </div>


                    {{-- Grafico visualizzazioni --}}
                    <div id="graph-container" class="p-5">
                        <canvas data-views="{{ $apartment->views }}" id="myChart"></canvas>
                        <select class="form-select" id="graph-type">
                            <option selected value="bar">Barre</option>
                            <option value="line">Lineare</option>
                            <option value="pie">Torta</option>
                            <option value="doughnut">Anello</option>
                            <option value="polarArea">Polar Area</option>
                            <option value="radar">Radar</option>
                            <option value="scatter">Scatter</option>
                        </select>
                    </div>


                    <div class="card-footer d-flex align-items-center justify-content-between">
                        {{-- Gruppo pulsanti navigazione --}}
                        <div id="btn-group">
                            {{-- Pulsante home --}}
                            <a href="{{ route('admin.home') }}" class="btn btn-primary me-2"><i
                                    class="fa-solid fa-arrow-left me-2"></i>{{ __('Torna alla Home') }}</a>
                            {{-- Pulsante per tornare al pannello di controllo --}}
                            <a href="{{ route('apartments.index') }}" class="btn btn-secondary"><i
                                    class="fa-solid fa-bars me-2"></i>{{ __('Torna alla lista Appartamenti') }}</a>
                        </div>
                        {{-- Gruppo pulsanti azione --}}
                        <div id="btn-action-group">
                            <div class="d-flex justify-content-end gap-3">
                                {{-- Pulsante modifica --}}
                                <a href="{{ route('apartments.edit', $apartment->id) }}" class="btn btn-warning"><i
                                        class="fa-solid fa-pencil me-2"></i>{{ __('Modifica') }}</a>
                                {{-- Form(pulsante) eliminazione --}}
                                <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST"
                                    class="delete-form" data-bs-toggle="modal" data-bs-target="#delete-modal"
                                    data-title="{{ $apartment->title }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i
                                            class="fa-solid fa-trash-can me-2"></i>{{ __('Elimina') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
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





        // Grafico visualizzazioni
        const ctx = document.getElementById('myChart');
        const graphType = document.getElementById('graph-type')

        views = JSON.parse(ctx.dataset
            .views
        ); // Array di visualizzazioni (Arriva come stringa e tramite JSON.parse lo riconverto in array di oggetti)
        console.log(views)
        const daysWithViews = views.reduce((res, view) => {
            if (!res.includes(view.date)) res.push(view.date);
            return res;
        }, [])

        let viewsPerDay = {}
        // Trasformo viewsPerDay in un oggetto dove ogni chiave è una data e ha come valore corrispettivo il numero di visualizzazioni di quel giorno
        for (let view of views) {
            let date = view.date;
            viewsPerDay[date] = (viewsPerDay[date] || 0) + 1;
        }
        console.log('Vies per day prima:', viewsPerDay)

        // Riordino gli elementi dell'oggetto per chiave
        viewsPerDay = Object.fromEntries(
            Object.entries(viewsPerDay).sort(([chiaveA], [chiaveB]) => chiaveA.localeCompare(chiaveB))
        );

        console.log('Views per day dopo:', viewsPerDay)

        const graph = new Chart(ctx, {
            // type: 'pie',
            // type: 'doughnut',        //SCEGLI IL TIPO DI GRAFICO
            // type: 'line',
            // type: 'bar',
            type: graphType.value,
            data: {
                labels: Object.keys(
                    viewsPerDay), // Creo una barra per ogni giorno (chiave nell'oggetto viewsPerDay)
                datasets: [{
                    label: 'Visualizzazioni al giorno',
                    data: Object.keys(viewsPerDay).map(function(
                        date
                    ) { // Ad ogni barra assegno il valore delle sue visualizzazioni
                        return viewsPerDay[date];
                    }),
                    borderWidth: 1
                }]
            },
            options: {
                layout: {
                    padding: 0 // Da qui modifica il padding del grafico
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                // plugins: {
                //     subtitle: {
                //         display: true,
                //         text: 'Custom Chart Subtitle'
                //     }
                // }
            }
        });
        console.log(graph)
        graphType.addEventListener('change', () => {
            console.log(graphType.value)
            graph.config.type = graphType.value;
            graph.update();
        })
    </script>
@endsection
