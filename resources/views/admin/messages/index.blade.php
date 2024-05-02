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
                <th scope="col" class="text-white"><i class="fa-solid fa-paper-plane  me-2  icon-border "></i>Mittente</th>
                <th scope="col" class="text-white"><i class="fa-solid fa-envelope-open  me-2  icon-border"></i>Oggetto</th>
                <th scope="col" class="text-white"><i class="fa-solid fa-eye  me-2  icon-border"></i>Anteprima</th>
                <th class="text-center text-white brd-right" scope="col"><i class="fa-solid fa-gamepad icon-border"></i>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
            <tr>
                <td class="text-center">
                    <!-- Immagine dell'appartamento associato al messaggio -->
                    <img style="width: 50px" src="{{ asset('storage/' . $message->apartment->image) }}" alt="Appartamento">
                </td>
                <td>{{ $message->apartment->title }}</td>
                <td>{{ $message->apartment->address }}</td>
                <td>{{ $message->name }} {{ $message->last_name }}</td>
                <td>{{ $message->subject }}</td>
                <td>{{ substr($message->text, 0, 30) }}{{ strlen($message->text) > 50 ? "..." : "" }}</td>
                <td>
                    <div class="d-flex justify-content-center  gap-2">
                        <!--Bottone dettaglio-->
                    <a href="{{ route('messages.show', $message) }}" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                    <!-- Form per la cancellazione -->
                    <form id="delete-form-{{ $message->id }}" action="{{ route('messages.destroy', $message) }}" method="POST" class="delete-form" data-bs-toggle="modal" data-bs-target="#delete-modal" data-title="{{ $message->title }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                    </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Al momento non hai nessun messaggio</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

     {{-- Paginazione --}}
    @if ($messages->hasPages())
        {{ $messages->links() }}
    @endif

    <!-- Modale Eliminazione -->
    @include('includes.delete_modal')
@endsection
@section('script')
    @vite('resources/js/delete_confirmation.js')
@endsection
