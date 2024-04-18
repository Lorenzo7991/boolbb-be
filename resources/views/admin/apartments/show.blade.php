@extends('layouts.app') 

@sectiono('title', '{{ $apartment->title }}')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $apartment->title }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                           <!--  <img src="{{ $apartment->image }}" class="img-fluid mb-3" alt="{{ $apartment->title }}"> -->
                        </div>
                        <div class="col-md-6">
                            <p><strong>Indirizzo:</strong> {{ $apartment->address }}</p>
                            <p><strong>Descrizione:</strong> {{ $apartment->description }}</p>
                            <p><strong>Stanze:</strong> {{ $apartment->rooms }}</p>
                            <p><strong>Letti:</strong> {{ $apartment->beds }}</p>
                            <p><strong>Bagni:</strong> {{ $apartment->bathrooms }}</p>
                            <p><strong>Metri quadrati:</strong> {{ $apartment->square_meters }}</p>
                            <p><strong>longitudine:</strong> {{ $apartment->latitude}}</p>
                            <p><strong>latitudine:</strong> {{ $apartment->longitude}}</p>
                            <p><strong>Pubblicato:</strong> {{ $apartment->is_visible ? 'Si' : 'No' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
