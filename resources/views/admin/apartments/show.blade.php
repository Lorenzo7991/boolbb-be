@extends('layouts.app')

@section('title', $apartment->title)

{{-- Sezione per includere CDNS fontAwsome --}}
@section('cdns')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous">
@endsection


@section('content')
@if ($message = session('message'))
    <div class="alert alert-success }}" role="alert">
        {{ $message }}
    </div>
@endif

        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header fs-3"><strong>{{ $apartment->title }}</strong></div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                     <img src="{{ asset('storage/' . asset('storage/' . $apartment->image)) }}" class="img-fluid mb-3"
                                    alt="{{ $apartment->title }}">
                                </div>
                                <div class="col-md-6">
                                    {{-- descrizione dell'appartamento --}}
                                    <p><strong>Descrizione:</strong> {{ $apartment->description }}</p>
                                    {{-- gruppo informazioni stanze, letti e bagni ecc... --}}
                                    <div id="services" class="d-flex align-items-center gap-3">
                                        <p><i class="fa-solid fa-house me-2"></i><strong>Stanze:</strong>
                                       
                                        {{ $apartment->rooms }}</p>
                                        <p><i class="fa-solid fa-bed me-2"></i><strong>Letti:</strong> {{ $apartment->beds }}
                                    
                                    </p>
                                        <p><i class="fa-solid fa-toilet me-2"></i><strong>Bagni:</strong>
                                       
                                        {{ $apartment->bathrooms }}</p>
                                        <p><i class="fa-solid fa-ruler me-2"></i><strong>Metri quadrati:</strong>
                                       
                                        {{ $apartment->square_meters }}mq</p>
                                    </div>
                                   {{-- indirizzo (latitudine e longitudine?) --}}
                                    <p><strong>Indirizzo:</strong> {{ $apartment->address }}</p>
                                    <p><strong>longitudine:</strong> {{ $apartment->latitude  }}</p>
                                    <p><strong>latitudine:</strong> {{ $apartment->longitude  }}</p>
                                  {{-- stato pubblicazione --}}
                                     <p><strong>Pubblicato:</strong> {!! $apartment->is_visible

    ? '<i class="fa-solid fa-circle-check"></i>'

    : '<i class="fa-solid fa-circle-xmark"></i>' !!}</p>
                                </div>
                            </div>
                        </div>

                    <div class="card-footer d-flex align-items-center justify-content-between">
                        {{-- Grupo pulsanti navigazione --}}
                        <div id="btn-group">
                            {{-- Pulsante home --}}
                            <a href="{{ route('admin.home') }}" class="btn btn-primary me-2"><i
                                    class="fa-solid fa-arrow-left me-2"></i>{{ __('Torna alla Home') }}</a>
                            {{-- Pulsante per tornare al pannello di controllo --}}
                            <a href="{{ route('apartments.index') }}" class="btn btn-secondary"><i
                                    class="fa-solid fa-bars me-2"></i>{{ __('Torna alla lista Appartamenti') }}</a>
                        </div>
                        {{-- Gruppo pulsanti azione --}}
                        <div id="btn-action-group">
                            <div class="d-flex justify-content-end gap-3">
                                {{-- Pulsante modifica --}}
                                <a href="{{ route('apartments.edit', $apartment->id) }}" class="btn btn-warning"><i
                                        class="fa-solid fa-pencil me-2"></i>{{ __('Modifica') }}</a>
                                {{-- Form(pulsante) eliminazione --}}
                                <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i
                                            class="fa-solid fa-trash-can me-2"></i>{{ __('Elimina') }}</button>
                                </form>
                            </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        {{-- Grupo pulsanti navigazione --}}
                        <div id="btn-group">
                            {{-- Pulsante home --}}
                            <a href="{{ route('admin.home') }}" class="btn btn-primary me-2"><i
                                    class="fa-solid fa-arrow-left me-2"></i>{{ __('Torna alla Home') }}</a>
                            {{-- Pulsante per tornare al pannello di controllo --}}
                            <a href="{{ route('apartments.index') }}" class="btn btn-secondary"><i
                                    class="fa-solid fa-bars me-2"></i>{{ __('Torna alla lista Appartamenti') }}</a>
                        </div>
                        {{-- Gruppo pulsanti azione --}}
                        <div id="btn-action-group">
                            <div class="d-flex justify-content-end gap-3">
                                {{-- Pulsante modifica --}}
                                <a href="{{ route('apartments.edit', $apartment->id) }}" class="btn btn-warning"><i
                                        class="fa-solid fa-pencil me-2"></i>{{ __('Modifica') }}</a>
                                {{-- Form(pulsante) eliminazione --}}
                                <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i
                                            class="fa-solid fa-trash-can me-2"></i>{{ __('Elimina') }}</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
