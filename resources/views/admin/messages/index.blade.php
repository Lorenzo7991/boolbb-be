@extends('layouts.app')

@section('title', 'Messaggi')

@section('content')
<div class="container">
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
            @forelse($apartmentsWithMessages as $apartment)
            <tr>
                <td class="text-center">
                    <img src="{{ $apartment->image }}" alt="Appartamento">
                </td>
                <td>{{ $apartment->title }}</td>
                <td>{{ $apartment->address }}</td>
                @if ($apartment->messages->isNotEmpty())
                <td>{{ $apartment->messages->first()->name }}</td>
                <td>{{ $apartment->messages->first()->subject }}</td>
                <td>{{ $apartment->messages->first()->text }}</td>
                <td class="text-center">
                    <a href="{{ route('messages.show', $apartment->messages->first()) }}"><i class="fas fa-eye"></i></a>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Al momento non hai nessun messaggio</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
