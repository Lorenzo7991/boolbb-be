@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="fs-1 fw-bolder text-center home-title my-4">
            Opzioni Profilo: {{ Auth::user()->name }}
        </h2>
        <div class="card p-4 mb-4 bg-white shadow rounded-lg">

            @include('profile.partials.update-profile-information-form')

        </div>

        <div class="card p-4 mb-4 bg-white shadow rounded-lg">


            @include('profile.partials.update-password-form')

        </div>

        <div class="card p-4 mb-4 bg-white shadow rounded-lg">


            @include('profile.partials.delete-user-form')

        </div>
    </div>
@endsection
@section('script')
    @vite('resources/js/profile_edit_form_validation')

    @vite('resources/js/password_update_validation')
@endsection
