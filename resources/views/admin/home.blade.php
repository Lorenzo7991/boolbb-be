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
        @endsection
                    
                    
