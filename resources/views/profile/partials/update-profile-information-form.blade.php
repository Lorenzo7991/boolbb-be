<section>
    <header>
        <h2 class="text-secondary">
            {{ __('Informazioni del profilo') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __('Modifica le informazioni del tuo profilo.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="mb-2 row">
            {{-- Nome --}}
            <div class="col-6">
                <label for="name">{{ __('Nome') }}</label>
                <input class="form-control" type="text" name="name" id="name"
                    value="{{ old('name', $user->name) }}" required autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->get('name') }}</strong>
                    </span>
                @enderror
            </div>

            {{-- Cognome --}}
            <div class="col-6">
                <label for="last_name">{{ __('Cognome') }}</label>
                <input class="form-control" type="text" name="last_name" id="last_name"
                    value="{{ old('last_name', $user->last_name) }}" required>
                @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->get('last_name') }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="mb-2 row ">

            {{-- Email --}}
            <div class="col-8">
                <label for="email">
                    {{ __('Email') }}
                </label>

                <input id="email" name="email" type="email" class="form-control"
                    value="{{ old('email', $user->email) }}" required autocomplete="username" />

                @error('email')
                    <span class="alert alert-danger mt-2" role="alert">
                        <strong>{{ $errors->get('email') }}</strong>
                    </span>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-muted">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="btn btn-outline-dark">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-success">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Data di nascita --}}
            <div class="col-4">
                <label for="date_of_birth">{{ __('Data di nascita') }}</label>
                <input class="form-control" type="date" name="date_of_birth" id="date_of_birth"
                    value="{{ old('date_of_birth', $user->date_of_birth) }}" required>
                @error('date_of_birth')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->get('date_of_birth') }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="d-flex align-items-center gap-4">
            <button class="btn btn-primary" type="submit">{{ __('Salva') }}</button>

            @if (session('status') === 'profile-updated')
                <script>
                    const show = true;
                    setTimeout(() => show = false, 2000)
                    const el = document.getElementById('profile-status')
                    if (show) {
                        el.style.display = 'block';
                    }
                </script>
                <p id='profile-status' class="fs-5 text-muted">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
