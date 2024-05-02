@extends('layouts.app')

@section('content')
<div class="container">
     <h2 class="home-title fs-1 fw-bolder mt-5 py-2">
                            {{ __('Dashboard') }}
                        </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}

                  
                </div>
                
            </div>
             <h2 class="home-title fs-1 fw-bolder mt-3 py-2">
                            {{ __('Messaggi') }}
                        </h2>
              <table class="table mt-3">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center text-white brd-left"><i class=" ps-1 fa-solid fa-camera-retro icon-border"></i></th>
                                <th scope="col" class="text-white"><i class="fa-solid fa-tag me-2  icon-border"></i>Appartamento</th>
                                <th scope="col" class="text-white"><i class="fa-solid fa-location-dot  me-2  icon-border"></i>Indirizzo</th>
                                <th scope="col" class="text-white"><i class="fa-solid fa-paper-plane  me-2  icon-border"></i>Mittente</th>
                                <th scope="col" class="text-white"><i class="fa-solid fa-envelope-open  me-2  icon-border"></i>Oggetto</th>
                                <th scope="col" class="text-white"><i class="fa-solid fa-eye  me-2  icon-border"></i>Anteprima</th>
                                <th class="text-center text-white brd-right" scope="col"><i class="fa-solid fa-gamepad icon-border"></i>
                            </tr>
                        </thead>
                        <tbody>
                        
                            <tr>
                            <td colspan="7" class="text-center">
                                <span>Non ci sono nuovi messaggi</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endsection
                    
                    
