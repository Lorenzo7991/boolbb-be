<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
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
        $apartments = Apartment::whereUserId(Auth::id())->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->paginate(5);
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

    /**
     * Store for creating a new resource.
     */
    public function store(StoreApartmentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        // Ottieni le coordinate fornite dal form
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        // Creazione dell'appartamento
        $apartment = new Apartment();
        $apartment->fill($data);
        $apartment->latitude = $latitude;
        $apartment->longitude = $longitude;

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
    }



    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        Carbon::setLocale('it');
        $current_date = Carbon::now('Europe/Rome');
        $latest_expiration_string = Apartment::find($apartment->id)->sponsorships()->max('expire_date'); // Stringa
        $latest_expiration = new DateTime($latest_expiration_string); // La converto in formato DateTime

        if ($current_date > $latest_expiration) {
            $latest_expiration_string = null;
        }

        if (!(Auth::id() == $apartment->user_id))
            return to_route('admin.home')->with('type', 'danger')->with('message', 'Non sei autorizzato ad eseguire questa azione');
        return view('admin.apartments.show', compact('apartment', 'latest_expiration_string'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        if (!(Auth::id() == $apartment->user_id))
            return to_route('admin.home')->with('type', 'danger')->with('message', 'Non sei autorizzato ad eseguire questa azione');
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

        if (Arr::exists($data, 'image')) {
            if ($apartment->image) {
                Storage::delete($apartment->image); // Verifica se c'è già un'immagine e la elimina
            }
            $extension = $data['image']->extension(); // Restituisce l'estensione del file senza punto
            $img_url = Storage::putFileAs('apartment_images', $data['image'], Str::slug($data['title']) . ".$extension");
            $data['image'] = $img_url;
        }

        // Aggiorno i dati dell'appartamento con i nuovi dati
        $apartment->update($data);

        // Se l'array $data contiene una chiave denominata 'services', sincronizzo la relazione tra l'appartamento e i servizi
        if (Arr::exists($data, 'services')) {
            $apartment->services()->sync($data['services']);
        }
        // Se l'array $data non contiene una chiave denominata 'services' e l'appartamento ha dei servizi associati, elimino tutte le relazioni
        elseif (!Arr::exists($data, 'services') && $apartment->services()->exists()) {
            $apartment->services()->detach();
        }

        return redirect()->route('apartments.show', $apartment)->with('message', 'Appartamento aggiornato con successo')->with('type', 'success');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return to_route('apartments.index')->with('message', "Appartamento eliminato con successo")->with('type', 'success');
    }


    public function toggleVisibility(Apartment $apartment)
    {
        $apartment->is_visible = !$apartment->is_visible;
        $apartment->save();
        return back();
    }

    public function sponsored()
    {
        Carbon::setLocale('it');
        $current_date = Carbon::now('Europe/Rome');
        $sponsoredApartments = Apartment::whereHas('sponsorships', function ($query) use ($current_date) {
            // Filtra le sponsorship con scadenza maggiore della data attuale
            $query->where('expire_date', '>', $current_date);
        })
            ->with(['sponsorships' => function ($query) use ($current_date) {
                // Seleziona la data di scadenza
                $query->where('expire_date', '>', $current_date);
            }])
            ->whereHas('sponsorships', function ($query) use ($current_date) {
                // Seleziona gli appartamenti con la massima data di scadenza
                $query->where('expire_date', DB::raw('(SELECT MAX(expire_date) FROM apartment_sponsorship WHERE apartment_id = apartments.id)'));
            })
            ->addSelect([
                'expiration_date' => DB::table('apartment_sponsorship')
                    ->select('expire_date')
                    ->whereColumn('apartment_id', 'apartments.id')
                    ->orderByDesc('expire_date')
                    ->limit(1),
            ])
            ->whereUserId(Auth::id())
            ->get();
        // Apartment::whereHas('sponsorships', function ($query) use ($current_date) {
        //     // Filtra le sponsorship con scadenza maggiore della data attuale
        //     $query->where('expire_date', '>', $current_date);
        // })->with(['sponsorships' => function ($query) use ($current_date) {
        //     // Seleziona la data di scadenza
        //     $query->where('expire_date', '>', $current_date);
        // }])->get();
        return view('admin.apartments.sponsored', compact('sponsoredApartments'));
    }
}
