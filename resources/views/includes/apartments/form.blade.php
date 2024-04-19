@if ($apartment->exists)
    <form action="{{ route('apartments.update', $apartment) }}" method="POST" enctype="multipart/form-data" novalidate>
        @method('PUT')
    @else
        <form action="{{ route('apartments.store') }}" method="POST" enctype="multipart/form-data" novalidate>
@endif

@csrf

<div class="row">
    <div class="col-6">
        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text" name="title"
                class="form-control @error('title') is-invalid @elseif(old('title', '')) is-valid @enderror"
                id="title" placeholder="Inserisci il titolo" value="{{ old('title', $apartment->title) }}">
        </div>
    </div>

    <div class="col-6">
        <div class="mb-3">
            <label for="address" class="form-label">Via</label>
            <input type="text" name="address"
                class="form-control @error('address') is-invalid @elseif(old('address', '')) is-valid @enderror"
                id="address" placeholder="Inserisci la via" value="{{ old('address', $apartment->address) }}">
        </div>
    </div>

    <div class="col-12">
        <div class="mb-3">
            <label for="description" class="form-label">Descrizione</label>
            <textarea name="description"
                class="form-control @error('description') is-invalid @elseif(old('description', '')) is-valid @enderror"
                id="description" cols="30" rows="10">
            {{ old('description', $apartment->description) }}
        </textarea>
        </div>
    </div>

    <div class="col-3">
        <div class="mb-3">
            <label for="rooms" class="form-label">Numero di stanze</label>
            <input type="number" name="rooms"
                class="form-control @error('rooms') is-invalid @elseif(old('rooms', '')) is-valid @enderror"
                id="rooms" placeholder="Inserisci numero stanze" value="{{ old('rooms', $apartment->rooms) }}">
        </div>
    </div>
    <div class="col-3">
        <div class="mb-3">
            <label for="beds" class="form-label">Numero di letti</label>
            <input type="number" name="beds"
                class="form-control @error('beds') is-invalid @elseif(old('beds', '')) is-valid @enderror"
                id="beds" placeholder="Inserisci numero letti" value="{{ old('beds', $apartment->beds) }}">
        </div>
    </div>
    <div class="col-3">
        <div class="mb-3">
            <label for="bathrooms" class="form-label">Numero di bagni</label>
            <input type="number" name="bathrooms"
                class="form-control @error('bathrooms') is-invalid @elseif(old('bathrooms', '')) is-valid @enderror"
                id="bathrooms" placeholder="Inserisci numero bagni"
                value="{{ old('bathrooms', $apartment->bathrooms) }}">
        </div>
    </div>
    <div class="col-3">
        <div class="mb-3">
            <label for="square_meters" class="form-label">Metri quadrati</label>
            <input type="number" name="square_meters"
                class="form-control @error('square_meters') is-invalid @elseif(old('square_meters', '')) is-valid @enderror"
                id="square_meters" placeholder="Inserisci metri quadrati"
                value="{{ old('square_meters', $apartment->square_meters) }}">
        </div>
    </div>

    <div class="col-11">
        <div class="mb-3">
            <label for="image" class="form-label">Inserisci un'immagine</label>
            {{-- Fake input file --}}
            <div @class(['input-group', 'd-none' => !$apartment->image]) id="fake-image-field">
                <button class="btn btn-outline-secondary" type="button" id="change-image-btn">Scegli il
                    file</button>
                <input type="text" class="form-control" disabled value="{{ old('image', $apartment->image) }}">
            </div>
            <input type="file" name="image"
                class="form-control @if ($apartment->image) d-none @endif @error('image') is-invalid @elseif(old('image', '')) is-valid @enderror"
                id="image" placeholder="Immagine..." value="{{ old('image', $apartment->image) }}">
            @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @else
                <div class="form-text">
                    Carica un file immagine
                </div>
            @enderror
        </div>
    </div>
    <div class="col-1">
        <div class="mb-3">
            <img src="{{ old('image', $apartment->image)
                ? asset('storage/' . old('image', $apartment->image))
                : 'https://marcolanci.it/boolean/assets/placeholder.png' }}"
                class="img-fluid" alt="immagine appartamento" id="preview">
        </div>
    </div>
    <div class="col-10">
        @foreach ($services as $service)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="services[]" id="{{ "service-$service->id" }}"
                    value="{{ $service->id }}" @if (in_array($service->id, old('services', $prev_services ?? []))) checked @endif>
                <label class="form-check-label" for="{{ "service-$service->id" }}">
                    {{ $service->label }}</label>
            </div>
        @endforeach
    </div>
    <div class="col-2 d-flex justify-content-end">
        <div class="form-check form-switch">
            <input class="form-check-input" value="1" type="checkbox" id="is_visible" name="is_visible"
                @if (old('is_visible', $apartment->is_visible)) checked @endif>
            <label class="form-check-label" for="is_visible">
                Visibile
            </label>
        </div>
    </div>
</div>

<hr>

<div class="d-flex align-items-center justify-content-between">
    <a href="{{ route('apartments.index') }}" class="btn btn-primary">Torna alla lista</a>

    <div class="d-flex align-items-center gap-2">
        <button type="reset" class="btn btn-secondary"><i class="fas fa-eraser me-2"></i>Svuota i campi</button>
        <button type="submit" class="btn btn-success"><i class="fas fa-floppy-disk me-2"></i>Salva</button>
    </div>
</div>



</form>

<script>
    const placeholder = 'https://marcolanci.it/boolean/assets/placeholder.png';
    const inputImage = document.getElementById('image');
    const preview = document.getElementById('preview');
    const changeImageButton = document.getElementById('change-image-btn');
    const fakeImageField = document.getElementById('fake-image-field');

    // Gestione image preview
    let blobUrl;
    inputImage.addEventListener('change', () => {

        // Controllo se è stato selezionato un file
        if (inputImage.files && inputImage.files[0]) {
            // prendo il file
            const file = inputImage.files[0];
            // preparo un url temporaneo
            blobUrl = URL.createObjectURL(file);
            preview.src = blobUrl;
        } else {
            preview.src = placeholder;
        }
    })

    window.addEventListener('beforeunload', () => {
        if (blobUrl) URL.revokeObjectURL(blobUrl);
    })

    // Gestione campo file
    // al click del bottono cambio l'input mostrato
    changeImageButton.addEventListener('click', () => {
        fakeImageField.classList.add('d-none');
        inputImage.classList.remove('d-none');
        preview.src = placeHolder;
        inputImage.click();
    })
</script>
