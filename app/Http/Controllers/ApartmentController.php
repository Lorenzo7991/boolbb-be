<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->paginate(5)->whereUserId(Auth::id())->get();
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $apartment = new Apartment();
        $services = Service::select('label', 'id')->get();
        return view('admin.apartments.create', compact('apartment', 'services'));
    }

    /** Documentazione della funzione di store:
     * Memorizza una risorsa appena creata nello storage.
     * Recupera tutti i dati dalla richiesta, inclusa l'ID dell'utente autenticato.
     * Invia una richiesta HTTP GET all'endpoint dell'API di geocodifica di TomTom con l'indirizzo fornito, ignorando la verifica del certificato SSL.
     * Se la richiesta ha successo:
     * - Estrae le coordinate (latitudine e longitudine) dai dati JSON di risposta.
     * - Crea una nuova istanza di Apartment.
     * - Riempie l'istanza di Apartment con i dati ricevuti.
     * - Imposta la latitudine e la longitudine dell'appartamento alle coordinate estratte.
     * - Salva l'appartamento nel database.
     * - Reindirizza l'utente alla pagina di visualizzazione del nuovo appartamento creato con un messaggio di successo.
     * Se la richiesta fallisce:
     * - Reindirizza l'utente al modulo di creazione con un messaggio di errore.
     */
    public function store(StoreApartmentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://api.tomtom.com/search/2/geocode/' . urlencode($request->address) . '.json', [
            'key' => 'AWAhF6IT1ChO0k28GMmsIysmnTgt0Gpp',
        ]);

        if ($response->successful()) {
            $jsonResponse = $response->json();
            if (isset($jsonResponse['results']) && count($jsonResponse['results']) > 0) {
                $coordinates = $jsonResponse['results'][0]['position'];
                $apartment = new Apartment();
                $apartment->fill($data);
                $apartment->latitude = $coordinates['lat'];
                $apartment->longitude = $coordinates['lon'];

                if ($request->hasFile('image')) {
                    $extension = $request->file('image')->extension();
                    $img_url = Storage::putFileAs('apartment_images', $request->file('image'), "$apartment->slug.$extension");
                    $apartment->image = $img_url;
                }

                $apartment->save();

                // Controllo se la chiave 'services' esiste nell'array $data.
                if (Arr::exists($data, 'services')) {
                    $apartment->services()->attach($data['services']);
                }

                return redirect()->route('apartments.show', $apartment)->with('message', 'Appartamento creato con successo')->with('type', 'success');
            } else {
                return back()->with('message', 'Indirizzo non valido o non trovato. Si prega di inserire un indirizzo valido.')->with('type', 'error');
            }
        } else {
            return back()->with('message', 'Errore durante la creazione dell\'appartamento. Si prega di riprovare.')->with('type', 'error');
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {

        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        $services = Service::select('label', 'id')->get();
        $prev_services = $apartment->services->pluck('id')->toArray();
        return view('admin.apartments.edit', compact('apartment', 'services', 'prev_services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $data = $request->validated();
        $data['is_visible'] = Arr::exists($data, 'is_visible');

        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://api.tomtom.com/search/2/geocode/' . urlencode($request->address) . '.json', [
            'key' => 'AWAhF6IT1ChO0k28GMmsIysmnTgt0Gpp',
        ]);

        if ($response->successful()) {
            $jsonResponse = $response->json();
            if (isset($jsonResponse['results']) && count($jsonResponse['results']) > 0) {
                $coordinates = $jsonResponse['results'][0]['position'];
                $data['latitude'] = $coordinates['lat'];
                $data['longitude'] = $coordinates['lon'];
            } else {
                return back()->with('message', 'Indirizzo non valido o non trovato. Si prega di inserire un indirizzo valido.')->with('type', 'error');
            }
        } else {
            return back()->with('message', 'Errore durante la creazione dell\'appartamento. Si prega di riprovare.')->with('type', 'error');
        }

        if (Arr::exists($data, 'image')) {
            if ($apartment->image) {
                Storage::delete($apartment->image); // controlla se c'è già un'immagine e la elimina
            }
            $extension = $data['image']->extension(); // restituisce l'estensione del file senza punto
            $img_url = Storage::putFileAs('apartment_images', $data['image'], Str::slug($data['title']) . ".$extension");
            $data['image'] = $img_url;
        }

        $apartment->update($data);

        // Verifico se l'array $data contiene una chiave denominata 'services'. Poi sincronizzo la relazione tra l'appartamento e i servizi
        if (Arr::exists($data, 'services'))
            $apartment->services()->sync($data['services']);

        // Verifico se l'array $data non contiene una chiave denominata 'services'. Poi elimino tutte le relazioni tra l'appartamento e i servizi
        elseif (!Arr::exists($data, 'services') && $apartment->has('services'))
            $apartment->services()->detach();

        return redirect()->route('apartments.show', $apartment)->with('message', 'Appartamento aggiornato con successo')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return to_route('apartments.index')->with('message', "Appartamento eliminato con successo")->with('type', 'danger');
    }


    public function toggleVisibility(Apartment $apartment)
    {
        $apartment->is_visible = !$apartment->is_visible;
        $apartment->save();
        return back();
    }
}
