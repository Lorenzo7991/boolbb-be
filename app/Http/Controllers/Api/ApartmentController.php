<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
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
        $apartments = Apartment::whereIsVisible(true)->latest()->with('user')->with('services')->get();
        return response()->json($apartments);
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
    public function show(Apartment $apartment)
    {
        //
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
        // $distance = $request->query('distance'); // Distanza in query string scelto dall'utente

        // Cerca gli appartamenti in un raggio di 20 km
        $distance = 20;

        // Geocodifica dell'indirizzo inserito dall'utente
        $response = Http::withOptions([
            'verify' => false
        ])->get('https://api.tomtom.com/search/2/geocode/' . urlencode($address) . '.json?key=JCA7jDznFGPlGy91V9K6LVAp8heuxKMU');

        // Verifica se la richiesta ha avuto successo e se sono stati trovati risultati
        if ($response->successful() && isset($response->json()['results']) && !empty($response->json()['results'])) {
            $coordinates = $response->json()['results'][0]['position'];

            $latitude = $coordinates['lat'];
            $longitude = $coordinates['lon'];

            $apartments = Apartment::select(
                'id',
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
                ->whereNull('deleted_at')
                ->whereIsVisible(true)
                ->having('distance', '<', $distance)
                ->orderBy('distance')
                ->get();

            return response()->json($apartments);
        } else {
            // Gestisci il caso in cui non ci sono risultati dalla geocodifica
            return response()->json(['error' => 'Nessun risultato trovato per l\'indirizzo specificato.']);
        }
    }
}
