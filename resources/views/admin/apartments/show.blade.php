@extends('layouts.app')

@section('title', $apartment->title)

{{-- Sezione per includere CDNS fontAwsome --}}
@section('cdns')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous">
@endsection

@section('content')
    @if ($message = session('message'))
        <div class="alert alert-success }}" role="alert">
            {{ $message }}
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center mt-4">
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
                                <p><strong>longitudine:</strong> {{ $apartment->latitude }}</p>
                                <p><strong>latitudine:</strong> {{ $apartment->longitude }}</p>

                                {{-- STATO PUBBLICAZIONE --}}
                                <p><strong>Pubblicato:</strong>
                                    {!! $apartment->is_visible
                                        ? '<i class="fa-solid fa-circle-check text-success "></i>'
                                        : '<i class="fa-solid fa-circle-xmark text-danger "></i>' !!}
                                </p>
                                <div class="d-flex">

                                    {{-- INSERIMENTO IMMAGINI AGGIUNTIVE --}}
                                    <form id="add-image" class="d-none" action="{{ route('image.store', $apartment->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="image"
                                            class="form-control  @error('image') is-invalid @elseif(old('image', '')) is-valid @enderror"
                                            id="secondary-image">
                                        <button type="submit" class="my-2 btn btn-small btn-success">Conferma</button>
                                    </form>
                                    <button id="add-img-btn" type="button" class="btn btn-primary mb-3"><i
                                            class="fas fa-plus"></i></button>
                                </div>

                            </div>

                            {{-- GALLERIA IMMAGINI --}}
                            <ul class="d-flex list-unstyled col-12 row row-cols-4">
                                @foreach ($apartment->images as $image)
                                    <li class="col">
                                        <figure class="show-figure">
                                            <img src="{{ asset('storage/' . $image->path) }}" class="rounded img-fluid"
                                                alt="image-{{ $image->id }}">
                                        </figure>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>

                    <div class="card-footer d-flex align-items-center justify-content-between">
                        {{-- Grupo pulsanti navigazione --}}
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
                                <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST">
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
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addImage = document.getElementById('add-image');
            const imgButton = document.getElementById('add-img-btn');

            imgButton.addEventListener('click', () => {
                addImage.classList.remove('d-none');
                imgButton.classList.add('d-none');
            });

            // Aggiungo la validazione del campo immagine vuoto al momento del submit
            addImage.addEventListener('submit', function(event) {
                const imageInput = document.getElementById('secondary-image');
                if (imageInput.files.length === 0) {
                    event.preventDefault(); 
                    alert('Seleziona un\'immagine prima di confermare!');
                }
            });
        });
    </script>
@endsection
