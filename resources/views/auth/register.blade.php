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
                                <div id="date-col" class="col-6">
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
                                <div id="email-col" class="col-6">
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
        //Recupero elementi da DOM 
        //Form
        const registerForm = document.getElementById('register-form')
        //Password
        const inputPassword = document.getElementById('password')
        //Conferma password
        const inputConfirmPassword = document.getElementById('password-confirm')
        //Messaggio feedback psw
        const passwordCol = document.getElementById('password-col')
        //Nome 
        const inputName = document.getElementById('name')
        //Cognome
        const inputLastName = document.getElementById('last_name')
        //Data di nascita
        const inputDateOfBirth = document.getElementById('date_of_birth')
        //Email
        const inputEmail = document.getElementById('email')
        //Formato della data
        const correctDateFormat = /^\d{4}-\d{2}-\d{2}$/
        //Formato della email
        const correctEmailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        //Colonna della data di nascita
        const dateCol = document.getElementById('date-col')
        //Colonna della email
        const emailCol = document.getElementById('email-col')
        
        registerForm.addEventListener('submit', e => { 
            let isValid = true;
            
            //Controllo se cè un messaggio di errore della password e lo cancello 
            const prevErrorPassword = document.getElementById('error-password')
            if (prevErrorPassword) {
                prevErrorPassword.remove();
                inputPassword.classList.remove('is-invalid')
            }
            //Controllo se cè un messaggio di errore della conferma password e lo cancello
            const prevErrorConfirmPassword = document.getElementById('error-confirm-password')
            if (prevErrorConfirmPassword) {
                prevErrorConfirmPassword.remove();
                inputPassword.classList.remove('is-invalid')
            }
            //Controllo se cè un messagio di errore nella data e lo cancello
            const prevErrorDate = document.getElementById('date-error')
            if (prevErrorDate) {
                prevErrorDate.remove();
                inputPassword.classList.remove('is-invalid')
            }
            //Controllo se cè un messaggio di errore nella mail e lo cancello
            const prevErrorEmail = document.getElementById('email-error')
            if (prevErrorEmail) {
                prevErrorEmail.remove();
                inputEmail.classList.remove('is-invalid')
            }

            //Validazione della password

            if (!inputPassword.value){
                
                isValid = false;
                inputPassword.classList.add('is-invalid');
                const errorPassword = document.createElement('span');
                errorPassword.id = 'error-password'
                errorPassword.classList.add('invalid-feedback');
                errorPassword.role = 'alert';
                errorPassword.innerHTML = '<strong>Devi inserire una password</strong>'
                passwordCol.appendChild(errorPassword);
                

            }   else if (inputPassword.value !== inputConfirmPassword.value) {
                isValid = false;
                inputPassword.classList.add('is-invalid');
                const errorConfirmPassword = document.createElement('span');
                errorConfirmPassword.id = 'error-confirm-password'
                errorConfirmPassword.classList.add('invalid-feedback');
                errorConfirmPassword.role = 'alert';
                errorConfirmPassword.innerHTML = '<strong>Il campo conferma password non corrisponde</strong>'
                passwordCol.appendChild(errorConfirmPassword)
            } else {
                
                inputPassword.classList.add('is-valid');
            }
            
            
            //Validazione formato data di nascita
             if  (inputDateOfBirth.value && !correctDateFormat.test(inputDateOfBirth.value)){
                isValid = false;
                inputDateOfBirth.classList.add('is-invalid');
                const dateError = document.createElement('span');
                dateError.id = 'date-error';
                dateError.classList.add('invalid-feedback');
                dateError.role = 'alert';
                dateError.innerHTML = '<strong> il formato della data di nascita non è corretto</strong>'
                dateCol.appendChild(dateError)               
            } else if (inputDateOfBirth.value) { 
                inputDateOfBirth.classList.add('is-valid');
            }
            

            //Validazione Email
            if(!inputEmail.value){
                isValid = false;
                inputEmail.classList.add('is-invalid');
                const emailError = document.createElement('span');
                emailError.id = 'email-error';
                emailError.classList.add('invalid-feedback');
                emailError.role = 'alert';
                emailError.innerHTML = '<strong>Devi inserire un Email</strong>'
                emailCol.appendChild(emailError)

            } else if (!correctEmailFormat.test(inputEmail.value)){
                isValid = false;
                inputEmail.classList.add('is-invalid');
                const emailError = document.createElement('span');
                emailError.id = 'email-error';
                emailError.classList.add('invalid-feedback');
                emailError.role = 'alert';
                emailError.innerHTML = '<strong> il formato dell\'email non è corretto</strong>'
                emailCol.appendChild(emailError)
            } else {
                
                inputEmail.classList.add('is-valid');
            }
            
            //Se cè un errore blocco il form
           if (!isValid)e.preventDefault();
        })
    </script>


@endsection
