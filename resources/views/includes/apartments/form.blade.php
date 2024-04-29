@if ($apartment->exists)
    <form action="{{ route('apartments.update', $apartment) }}" method="POST" enctype="multipart/form-data" novalidate
        class="apartment-form">
        @method('PUT')
    @else
        <form action="{{ route('apartments.store') }}" method="POST" enctype="multipart/form-data" novalidate
            class="apartment-form">
@endif

@csrf

<div id="form-alert"></div>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="row">
            <div class="col-12">
                <div class="mb-3">

                    {{-- TITOLO --}}
                    <label for="title" class="form-label">Titolo <span class="text-danger">*</span></label>
                    <input type="text" name="title"
                        class="form-control @error('title') is-invalid @elseif(old('title', '')) is-valid @enderror"
                        id="title" placeholder="Inserisci il titolo" value="{{ old('title', $apartment->title) }}">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3" id="search-box-container">
                    {{-- INDIRIZZO --}}
                    <label for="address" class="form-label">Via <span class="text-danger">*</span></label>
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Nuovi campi per le coordinate -->
                    <div class="col-6">
                            <div class="mb-3">
                                {{-- COORDINATE LATITUDINE --}}
                                <label for="latitude" class="form-label">Latitudine</label>
                                <input type="text" name="latitude"
                                 class="form-control" id="latitude" placeholder="Latitudine"
                                    value="{{ old('latitude', $apartment->latitude) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                {{-- COORDINATE LONGITUDINE --}}
                                <label for="longitude" class="form-label">Longitudine</label>
                                <input type="text" name="longitude"
                                 class="form-control" id="longitude" placeholder="Longitudine"
                                    value="{{ old('longitude', $apartment->longitude) }}" disabled>
                            </div>
                        </div>

        

















            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            {{-- NUMERO STANZE --}}
                            <label for="rooms" class="form-label">Numero di stanze <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="rooms"
                                class="form-control @error('rooms') is-invalid @elseif(old('rooms', '')) is-valid @enderror"
                                id="rooms" placeholder="1-50" value="{{ old('rooms', $apartment->rooms) }}"
                                min="1" max="50">
                            @error('rooms')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            {{-- NUMERO LETTI --}}
                            <label for="beds" class="form-label">Numero di letti <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="beds"
                                class="form-control @error('beds') is-invalid @elseif(old('beds', '')) is-valid @enderror"
                                id="beds" placeholder="1-50" value="{{ old('beds', $apartment->beds) }}"
                                min="1" max="50">
                            @error('beds')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            {{-- NUMERO BAGNI --}}
                            <label for="bathrooms" class="form-label">Numero di bagni <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="bathrooms"
                                class="form-control @error('bathrooms') is-invalid @elseif(old('bathrooms', '')) is-valid @enderror"
                                id="bathrooms" placeholder="1-50" value="{{ old('bathrooms', $apartment->bathrooms) }}"
                                min="1" max="50">
                            @error('bathrooms')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            {{-- METRI QUADRATI --}}
                            <label for="square_meters" class="form-label">Metri quadrati <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="square_meters"
                                class="form-control @error('square_meters') is-invalid @elseif(old('square_meters', '')) is-valid @enderror"
                                id="square_meters" placeholder="10-10000"
                                value="{{ old('square_meters', $apartment->square_meters) }}" min="10"
                                step="5">
                            @error('square_meters')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            {{-- PREZZO PER NOTTE --}}
                            <label for="price_per_night" class="form-label">Prezzo per notte <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="price_per_night"
                                class="form-control @error('price_per_night') is-invalid @elseif(old('price_per_night', '')) is-valid @enderror"
                                id="price_per_night" placeholder="...€"
                                value="{{ old('price_per_night', $apartment->price_per_night) }}" min="1">
                            @error('price_per_night')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 align-self-start">
                        {{-- IMMAGINE --}}
                        <label for="image" class="form-label">Inserisci un'immagine <span
                                class="text-danger">*</span></label>
                        {{-- Fake input file --}}
                        <div class="input-group @if (!$apartment->image) d-none @endif "
                            id="fake-image-field">
                            <button class="btn btn-outline-secondary" type="button" id="change-image-btn">Scegli
                                il
                                file</button>
                            <input type="text"
                                class="form-control @error('image') is-invalid @elseif(old('image', '')) is-valid @enderror"
                                disabled value="{{ old('image', $apartment->image) }}">
                        </div>
                        {{-- INPUT IMMAGINE --}}
                        <input type="file" name="image"
                            class="form-control @if ($apartment->image) d-none @endif @error('image') is-invalid @elseif(old('image', '')) is-valid @enderror"
                            id="image" placeholder="Immagine..." value="{{ old('image', $apartment->image) }}">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 align-self-center text-center d-flex justify-content-center">
                        <div class="mb-3">
                            {{-- PREVIEW IMMAGINE --}}
                            <figure class="form-figure">
                                <img src="{{ old('image', $apartment->image)
                                    ? asset('storage/' . old('image', $apartment->image))
                                    : 'https://marcolanci.it/boolean/assets/placeholder.png' }}"
                                    class="img-fluid m-4" alt="immagine appartamento" id="preview">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="mb-3">
            {{-- DESCRIZIONE --}}
            <label for="description" class="form-label">Descrizione</label>
            <textarea name="description"
                class="form-control @error('description') is-invalid @elseif(old('description', '')) is-valid @enderror"
                id="description" cols="30" rows="10">{{ old('description', $apartment->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <label>Servizi <span class="text-danger">*</span></label>
    <div id="services-wrapper"
        class="col-12 form-control @error('services') is-invalid @elseif(old('services', '')) is-valid @enderror">
        {{-- SERVIZI --}}
        @foreach ($services as $service)
            <div class="form-check form-check-inline ">
                <input class="form-check-input services-group" type="checkbox" name="services[]"
                    id="{{ "service-$service->id" }}" value="{{ $service->id }}"
                    @if (in_array($service->id, old('services', $prev_services ?? []))) checked @endif>
                <label class="form-check-label" for="{{ "service-$service->id" }}">
                    {{ $service->label }}</label>
            </div>
        @endforeach
    </div>
    @error('services')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
    <div class="col-12 d-flex justify-content-end">

        @if ($apartment->exists)
            {{-- SWITCH VISIBILITA' --}}
            <div class="form-check form-switch">
                @error('is_visible')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @else
                @enderror
                <input class="form-check-input" value="1" type="checkbox" id="is_visible" name="is_visible"
                    @if (old('is_visible', $apartment->is_visible)) checked @endif>
                <label class="form-check-label" for="is_visible">
                    Visibile
                </label>
            </div>
        @endif
    </div>
</div>

<hr>

<div class="d-flex align-items-center justify-content-between">
    <small>I campi contrassegnati con <span class="text-danger">*</span> sono
        obbligatori</small>
    <button type="submit" class="btn btn-success"><i class="fas fa-floppy-disk me-2"></i>Salva</button>
</div>


</form>

<script>
    const searchBoxContainer = document.getElementById('search-box-container');
    var options = {
        searchOptions: {
            key: "JCA7jDznFGPlGy91V9K6LVAp8heuxKMU",
            language: "it-IT",
            limit: 5,
        },
        autocompleteOptions: {
            key: "JCA7jDznFGPlGy91V9K6LVAp8heuxKMU",
            language: "it-IT",
        },
    };

    var ttSearchBox = new tt.plugins.SearchBox(tt.services, options);
    var searchBoxHTML = ttSearchBox.getSearchBoxHTML();
    searchBoxContainer.appendChild(searchBoxHTML);

    // Input type text per l'indirizzo
    const inputAddressBox = document.querySelector('.tt-search-box-input');
    inputAddressBox.name = "address";
    inputAddressBox.classList.add('form-control');
    inputAddressBox.id = "address";
    inputAddressBox.placeholder = "Via...";
    inputAddressBox.classList.add('form-control');
    inputAddressBox.value = "{{ old('address', $apartment->address) }}";

    // Rimozione lente ingrandimento
    const inputAddressDirectParent = document.querySelector('.tt-search-box-input-container');
    inputAddressDirectParent.removeChild(inputAddressDirectParent.firstElementChild);
    inputAddressDirectParent.classList.add('d-flex', 'flex-column');
    const closeButton = document.querySelector('.tt-search-box-close-icon');
    closeButton.remove();

    // Event listener per intercettare i clic sugli elementi suggeriti nella dropdown della search box
    const searchResultListContainer = document.querySelector('.tt-search-box-result-list-container');
    searchResultListContainer.addEventListener('click', function(event) {
        const selectedResult = event.target.innerText;
        const addressInput = document.getElementById('address');
        
        // Chiamata API per ottenere le coordinate dall'indirizzo selezionato
        fetch(`https://api.tomtom.com/search/2/geocode/${selectedResult}.json?key=JCA7jDznFGPlGy91V9K6LVAp8heuxKMU&limit=1`)
            .then(response => response.json())
            .then(data => {
                const coordinates = data.results[0].position;
                const latitudeInput = document.getElementById('latitude');
                const longitudeInput = document.getElementById('longitude');
                latitudeInput.value = coordinates.lat;
                longitudeInput.value = coordinates.lon;
            })
            .catch(error => {
                console.error('Errore durante la richiesta delle coordinate:', error);
            });
    });

    @error('address')
        inputAddressBox.classList.add('is-invalid');
        const errorMessage = document.createElement('div');
        errorMessage.classList.add('invalid-feedback');
        errorMessage.innerText = '{{ $message }}';
        inputAddressDirectParent.appendChild(errorMessage);
    @elseif (old('address', ''))
        inputAddressBox.classList.add('is-valid');
    @enderror

    const inputAddressContainer = document.querySelector('.tt-search-box');
    inputAddressContainer.classList.add('form-control', 'mt-0');
    inputAddressContainer.classList.add('mt-0');
    inputAddressContainer.style.padding = "0";
    inputAddressContainer.style.border = "none";

    const inputAddressContainerBox = document.querySelector('.tt-search-box-input-container');
    inputAddressContainerBox.style.padding = "0";
    inputAddressContainerBox.style.border = "none";
</script>
