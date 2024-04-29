@extends('layouts.app')

@section('title', 'Modifica Appartamento')

@section('content')
    <header>
        <h1 class="my-3">Modifica Appartamento</h1>
    </header>


    @include('includes.apartments.form')

@endsection

@section('script')
    @vite('resources/js/image_preview.js')
    @vite('resources/js/apartments_form_validation.js')

@endsection
