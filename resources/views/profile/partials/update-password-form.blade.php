<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Modifica Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Assicurati di usare una password sicura.') }}
        </p>
    </header>
    {{-- Form modifica password --}}
    <form id="update-password-form" method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="mb-2" id="current-pswrd-parent">
            {{-- Password attuale --}}
            <label for="current_password">{{ __('Password Attuale') }}</label>
            <input class="mt-1 form-control @error('current_password') is-invalid @enderror" type="password"
                name="current_password" id="current_password" autocomplete="current-password">
            @error('current_password')
                <span class="invalid-feedback mt-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-2" id="new-pswrd-parent">
            {{-- Nuova password --}}
            <label for="password">{{ __('Nuova Password') }}</label>
            <input class="mt-1 form-control @error('password') is-invalid @enderror" type="password" name="password"
                id="password" autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback mt-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-2" id="confirm-pswrd-parent">
            {{-- Conferma nuova password --}}
            <label for="password_confirmation">{{ __('Conferma Password') }}</label>
            <input class="mt-2 form-control @error('password_confirmation') is-invalid @enderror" type="password"
                name="password_confirmation" id="password_confirmation" autocomplete="new-password">
            @error('password_confirmation')
                <span class="invalid-feedback mt-2" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">{{ __('Salva') }}</button>

            @if (session('status') === 'password-updated')
                <script>
                    const show = true;
                    setTimeout(() => show = false, 2000)
                    const el = document.getElementById('status')
                    if (show) {
                        el.style.display = 'block';
                    }
                </script>
                <p id='status' class=" fs-5 text-muted">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
