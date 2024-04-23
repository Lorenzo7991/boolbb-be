{{-- Alert per i messaggi --}}
@session('message')
    <div class="alert alert-{{ session('type', 'info') }} alert-dismissible fade show" role="alert">
        {{ $value }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endsession

{{-- Alert di validazione form --}}
@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <h4>Ci sono dei campi non validi!</h4>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
