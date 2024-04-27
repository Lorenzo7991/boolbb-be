@extends('layouts.app')

@section('title', 'Crea Appartamento')

@section('content')
    <header>
        <h1 class="my-3">Nuovo Appartamento</h1>
    </header>


    @include('includes.apartments.form')

@endsection


@section('script')
    @vite('resources/js/image_preview.js')
    @vite('resources/js/apartments_form_validation.js')

@endsection
