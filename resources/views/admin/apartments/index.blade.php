@extends('layouts.app')


@section('title', 'Appartamenti')

@section('content')

<header class="container">
    <div class="d-flex justify-content-between align-items-center">
    <h1 class="text-center">Appartamenti</h1>
    <!--Bottone per andare alla pagina di creazione appartamento-->
    <a class="btn btn-success text-align-center" href="">Aggiungi appartamento</a>
</div>
</header>
<main class="container">

    <table class="table ">
        <thead>
        <!--Colonne tabella-->
            <tr>
                <th scope="col">Titolo</th>    
                <th scope="col">Indirizzo</th>              
                <th scope="col">Descrizione</th>
                <th scope="col">Immagine</th>              
                <th scope="col">Camere</th>              
                <th scope="col">Letti</th>
                <th scope="col">Bagni</th>
                <th scope="col">Metri Quadri</th>
                <th scope="col">Data creazione</th>
                <th class="text-center" scope="col">Console</th>
            </tr>
        </thead>
        <!--ciclo per girare sugli appartamenti e prendere i dettagli del singolo appartamento-->
        @foreach ($apartments as $apartment )       
        <tbody>
          <tr>
            <!--Titolo appartemento-->
            <th scope="row">{{$apartment->title}}</th>
            <!--Indirizzo appartemento-->
            <td>{{$apartment->address}}</td>
            <!--Descrizione appartemento-->
            <td>{{$apartment->description}}</td>
            <!--Immagine appartemento-->
            <td>URL dell'immagine </td>
            <!--Camere appartemento-->
            <td>{{$apartment->rooms}}</td>
            <!--Letti appartemento-->
            <td>{{$apartment->beds}}</td>
            <!--Bagni appartemento-->
            <td>{{$apartment->bathrooms}}</td>
            <!--Metri quadri appartemento-->
            <td>{{$apartment->square_meters}}</td>
            <!--Data creazione appartemento-->
            <td>{{$apartment->created_at}}</td>
            <td>
            <div class="d-flex gap-2"> 
                <!--Bottone dettaglio-->
              <a href="" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></a>
              <!--Bottone modifica-->
              <a class="btn btn-warning" href=""><i class="fa-solid fa-pen-to-square text-white"></i></a>
              <!--Bottone cancella-->
              <form id="delete-form" action="" method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit" ><i class="fa-solid fa-trash"></i></button>
                  </form>
              </div>
            </td>
         </tr>
        </tbody>
        @endforeach
      </table>
</main>

@endsection
@section('scripts')
@endsection