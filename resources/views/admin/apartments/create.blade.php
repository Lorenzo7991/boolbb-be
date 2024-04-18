@extends('layouts.app')

@section('title', 'Crea Appartamento')

@section('content')
    <header>
        <h1 class="my-3">Nuovo Appartamento</h1>
    </header>


    @include('includes.apartments.form')

@endsection
