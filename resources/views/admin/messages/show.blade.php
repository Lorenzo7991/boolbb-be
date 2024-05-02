@extends('layouts.app')

@section('title', $message->subject)

{{-- Includi CDNS fontAwesome --}}
@section('cdns')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    {{-- Titolo Messaggio --}}
                    <div class="card-header home-title fs-3"><strong>{{ $message->subject }}</strong></div>
                    <div class="card-body">
                        {{-- Dettagli Messaggio --}}
                        <div class="row">
                            <div class="col-md-6">
                                {{-- Mittente --}}
                                <p><strong>Mittente:</strong> {{ $message->name }} {{ $message->last_name }}</p>
                                {{-- Email Mittente --}}
                                <p><strong>Email Mittente:</strong> {{ $message->email }}</p>
                                {{-- Data e Ora --}}
                                <p><strong>Data e Ora:</strong> {{ $message->created_at }}</p>
                                {{-- Testo Messaggio --}}
                                <p><strong>Testo Messaggio:</strong> {{ $message->text }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        {{-- Pulsante per tornare indietro --}}
                        <a href="{{ route('messages.index') }}" class="btn btn-primary"><i
                                class="fa-solid fa-arrow-left me-2"></i>{{ __('Torna Indietro') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- Includi script per la conferma di eliminazione --}}
    @vite('resources/js/delete_confirmation.js')
@endsection
