@extends('layouts.app')

@section('content')
<div class="container">
     <h2 class="home-title fs-1 fw-bolder mt-5 py-2 text-center">
                            {{ __('Admin Home') }}
                        </h2>
    <div class="row justify-content-center">
        <div class="col mx-auto">
            <div class="card">
                <div class="card-header sponsor-cs-color text-white">
                <h3>{{ __('Benvenuto:') }} {{ Auth::user()->name }}</h3>
            </div>

                <div class="card-body fs-5 d-flex align-items-center justify-content-between">
                 @if (session('status'))
                    <div class="alert alert-success" role="alert">
                         {{ session('status') }}
                    </div>
                @endif
            <div>
                 {{ Auth::user()->name }}, {{ __('Ti sei autenticato correttamente!') }}
                    </div>
                <div class="ms-3"> <!-- Aggiungi un margine a sinistra per distanziare il bottone -->
                    <a href="{{ url('/apartments') }}" class="btn sponsor-cs-color btn-primary">Continua</a>
                </div>
            </div>
                
            </div>
        @endsection
                    
                    
