<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\View;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $current_date = Carbon::now('Europe/Rome');
        $apartments = Apartment::whereIsVisible(true)->latest()->with('user')->with('images')->with('services')->with('sponsorships')->get();
        $sponsored_apartments = Apartment::whereHas('sponsorships', function ($query) use ($current_date) {
            $query->where('expire_date', '>', $current_date);
        })->latest()->with('user')->with('images')->with('services')->with('sponsorships')->get();
        $all_apartments['all'] = $apartments;
        $all_apartments['sponsored'] = $sponsored_apartments;
        return response()->json($all_apartments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(String $slug)
    {
        $apartment = Apartment::whereSlug($slug)->with('images')->with('user')->with('services')->first();
        if (!$apartment) return response(null, 404);
        return response()->json($apartment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartment $apartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        //
    }

    public function search(Request $request)
    {
        $address = $request->query('address'); // Indirizzo in query string scelto dall'utente
        $distance = $request->query('distance'); // Distanza in query string scelto dall'utente
        $latitude = $request->query('latitude'); // Coordinata in arrivo dal front
        $longitude = $request->query('longitude'); // Coordinata arrivata dal front
        $price = $request->query('price'); // Prezzo in query string scelto dall'utente
        $rooms = $request->query('rooms'); // Numero stanze in query string scelto dall'utente
        $beds = $request->query('beds'); // Numero letti in query string scelto dall'utente
        $selectedServices = json_decode($request->query('services')); // Servizi selezionati dall'utente: arrivano come stringa e uso json_decode per ritrasformali in array

        // Se arriva un indirizzo in request fa il filtro per distanza
        if ($address) {
            $query = Apartment::select(
                'id',
                'user_id',
                'title',
                'slug',
                'address',
                'price_per_night',
                'description',
                'rooms',
                'beds',
                'bathrooms',
                'square_meters',
                'image',
                'latitude',
                'longitude',
                DB::raw("(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
            )
                ->having('distance', '<', $distance)
                ->orderBy('distance');
        } else {        // Altrimenti prende tutti gli appartamenti
            $query = Apartment::select(
                'id',
                'user_id',
                'title',
                'slug',
                'address',
                'price_per_night',
                'description',
                'rooms',
                'beds',
                'bathrooms',
                'square_meters',
                'image',
                'latitude',
                'longitude',
            );
        }

        //Se arriva un prezzo in request fa un filtro per prezzo
        if ($price) {
            $query->where('price_per_night', '<=', $price);
        }

        //Se arriva un numero di stanze in request fa un filtro per numero di stanze
        if ($rooms) {
            if ($rooms >= 8) {
                $query->where('rooms', '>=', $rooms);
            } else if ($rooms > 0 && $rooms < 8) {
                $query->where('rooms', '=', $rooms);
            }
        }

        //Se arriva un numero di letti in request fa un filtro per numero di letti
        if ($beds) {
            if ($beds >= 8) {
                $query->where('beds', '>=', $beds);
            } else if ($beds > 0 && $beds < 8) {
                $query->where('beds', '=', $beds);
            }
        }


        // Se arrivano dei servizi in request fa un filtro per servizi
        if ($selectedServices && count($selectedServices)) {
            $query->whereHas('services', function ($query) use ($selectedServices) {
                $query->whereIn('services.id', $selectedServices);
            }, '=', count($selectedServices));
        }

        $query->whereNull('deleted_at')
            ->whereIsVisible(true)
            ->with('user')
            ->with('services')
            ->with('images');


        $apartments = $query->get();

        return response()->json($apartments);

        // Geocodifica dell'indirizzo inserito dall'utente
        // $response = Http::withOptions([
        //     'verify' => false
        // ])->get('https://api.tomtom.com/search/2/geocode/' . urlencode($address) . '.json?key=JCA7jDznFGPlGy91V9K6LVAp8heuxKMU');

        // Verifica se la richiesta ha avuto successo e se sono stati trovati risultati
        // if ($response->successful() && isset($response->json()['results']) && !empty($response->json()['results'])) {
        //     $coordinates = $response->json()['results'][0]['position'];

        //     $latitude = $coordinates['lat'];
        //     $longitude = $coordinates['lon'];

        //     $apartments = Apartment::select(
        //         'id',
        //         'user_id',
        //         'title',
        //         'slug',
        //         'address',
        //         'price_per_night',
        //         'description',
        //         'rooms',
        //         'beds',
        //         'bathrooms',
        //         'square_meters',
        //         'image',
        //         'latitude',
        //         'longitude',
        //         DB::raw("(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance")
        //     )
        //         ->whereNull('deleted_at')
        //         ->whereIsVisible(true)
        //         ->having('distance', '<', $distance)
        //         ->orderBy('distance')
        //         ->with('user')
        //         ->with('services')
        //         ->with('images')
        //         ->get();

        //     return response()->json($apartments);
        // } else {
        //     // Gestisci il caso in cui non ci sono risultati dalla geocodifica
        //     return response()->json(['error' => 'Nessun risultato trovato per l\'indirizzo specificato.']);
        // }
    }
    public function services()
    {
        $services = Service::all();
        return response()->json($services);
    }

    public function countViews(Request $request)
    {
        $ip = $request->ip();
        $apartment_id = $request->apartment_id;
        $view = new View();
        $view->apartment_id = $apartment_id;
        $view->ip = $ip;
        $view->date = Carbon::today();
        $view->save();
        return response()->json('Visualizzazione aggiunta con successo');
    }
}
