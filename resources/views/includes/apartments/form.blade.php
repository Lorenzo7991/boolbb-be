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
            <input type="file" name="image"
                class="form-control @error('image') is-invalid @elseif(old('image', '')) is-valid @enderror"
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
    <div class="col-12 d-flex justify-content-end">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="is_visibile" name="is_visibile"
                @if (old('is_visibile', $apartment->is_visibile)) checked @endif>
            <label class="form-check-label" for="is_visibile">
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
