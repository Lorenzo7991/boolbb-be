@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body pb-0">
                        <form method="POST" action="{{ route('register') }}" novalidate id="register-form">
                            @csrf

                            <div class="mb-4 row">

                                {{-- Nome --}}
                                <div class="col-6">
                                    <label class="mb-2" for="name">{{ __('Name') }}</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Cognome --}}
                                <div class="col-md-6">
                                    <label class="mb-2" for="last_name">{{ __('Cognome') }}</label>
                                    <input id="last_name" type="text"
                                        class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                        value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                {{-- Data di nascita --}}
                                <div class="col-6">
                                    <label class="mb-2" for="date_of_birth">{{ __('Data di nascita') }}</label>

                                    <input id="date_of_birth" type="date"
                                        class="form-control @error('date_of_birth') is-invalid @enderror"
                                        name="date_of_birth" value="{{ old('date_of_birth') }}"
                                        autocomplete="date_of_birth">

                                    @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- Email --}}
                                <div class="col-6">
                                    <label class="mb-2" for="email">{{ __('Indirizzo E-Mail') }} <span
                                            class="text-danger">*</span></label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 row">
                                {{-- Password --}}
                                <div class="col-6" id="password-col">
                                    <label class="mb-2" for="password">{{ __('Password') }} <span
                                            class="text-danger">*</span></label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- Conferma password --}}
                                <div class="col-6">
                                    <label class="mb-2" for="password-confirm">{{ __('Confirm Password') }} <span
                                            class="text-danger">*</span></label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="mb-4 row mb-0">
                                <div class="col-6">
                                    <small>I campi contrassegnati con <span class="text-danger">*</span> sono
                                        obbligatori</small>
                                </div>
                                <div class="col-6 d-flex justify-content-end">

                                    {{-- Bottono di registrazione --}}
                                    <button type="submit" class="btn btn-primary mt-3" id="register-btn">
                                        {{ __('Registrati') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        const registerForm = document.getElementById('register-form')
        const inputPassword = document.getElementById('password')
        const inputConfirmPassword = document.getElementById('password-confirm')
        const passowordCol = document.getElementById('password-col')

        registerForm.addEventListener('submit', e => {
            const prevErrorMsg = document.getElementById('error-msg')
            if (prevErrorMsg) {
                prevErrorMsg.remove();
                inputPassword.classList.remove('is-invalid')
            }
            if (inputPassword.value !== inputConfirmPassword.value) {
                e.preventDefault();

                inputPassword.classList.add('is-invalid');
                const errorMsg = document.createElement('span');
                errorMsg.id = 'error-msg'
                errorMsg.classList.add('invalid-feedback');
                errorMsg.role = 'alert';
                errorMsg.innerHTML = '<strong>Il campo conferma password non corrisponde</strong>'
                passowordCol.appendChild(errorMsg);
            }
        })
    </script>
@endsection
