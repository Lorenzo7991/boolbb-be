@extends('layouts.app')

@section('title', 'Messaggi')

@section('content')
<div>
    <h2 class="home-title fs-1 fw-bolder mt-3 py-2 text-center">
        {{ __('Messaggi') }}
    </h2>
    <table class="table mt-3">
        <thead>
            <tr class="text-center">
                <th scope="col" class="text-center text-white brd-left"><i class=" ps-1 fa-solid fa-camera-retro icon-border"></i></th>
                <th scope="col" class="text-white d-none"><i class="fa-solid fa-clock me-2 icon-border"></i><span>Data e ora</span></th>
                <th scope="col" class="text-white"><i class="fa-solid fa-tag me-2  icon-border"></i><span class="d-none">Appartamento</span></th>
                <th scope="col" class="text-white d-none"><i class="fa-solid fa-location-dot  me-2  icon-border"></i><span>Indirizzo</span></th>
                <th scope="col" class="text-white "><i class="fa-solid fa-paper-plane  me-2  icon-border "></i><span class="d-none">Mittente</span></th>
                <th scope="col" class="text-white d-none"><i class="fa-solid fa-envelope-open  me-2  icon-border"></i><span>Oggetto</span></th>
                <th scope="col" class="text-white d-none"><i class="fa-solid fa-eye  me-2  icon-border"></i><span>Anteprima</span></th>
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
                <td class="d-none">{{ $message->created_at->format('d/m/Y H:i:s') }}</td>
                <td>{{ $message->apartment->title }}</td>
                <td class="d-none">{{ $message->apartment->address }}</td>
                <td >{{ $message->name }} {{ $message->last_name }}</td>
                <td class="d-none">{{ $message->subject }}</td>
                <td class="d-none">{{ substr($message->text, 0, 30) }}{{ strlen($message->text) > 30 ? "..." : "" }}</td>
                <td>
                    <div class="d-flex justify-content-center  gap-2">
                        <!--Bottone dettaglio-->
                    <a href="{{ route('messages.show', $message) }}" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                    <!-- Form per la cancellazione -->
                    <form class="d-none" id="delete-form-{{ $message->id }}" action="{{ route('messages.destroy', $message) }}" method="POST" class="delete-form" data-bs-toggle="modal" data-bs-target="#delete-modal" data-title="{{ $message->title }}">
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
    {{-- Paginazione --}}
    @if ($messages->hasPages())
       {{ $messages->links() }}
    @endif
</div>


    <!-- Modale Eliminazione -->
    @include('includes.delete_modal')
@endsection
@section('script')
    @vite('resources/js/delete_confirmation.js')
@endsection
