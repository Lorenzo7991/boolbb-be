<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::all();
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $apartment = new Apartment();
        return view('admin.apartments.create', compact('apartment'));
    }

    /** Store function documentation:
     * Store a newly created resource in storage.
     * Retrieve all data from the request, including the user ID of the authenticated user.
     * Send an HTTP GET request to the TomTom geocoding API endpoint with the provided address, ignoring SSL certificate verification.
     * If the request is successful:
     *   - Extract the coordinates (latitude and longitude) from the response JSON data.
     *   - Create a new Apartment instance.
     *   - Fill the Apartment instance with the received data.
     *   - Set the latitude and longitude of the apartment to the extracted coordinates.
     *   - Save the apartment to the database.
     *   - Redirect the user to the show page of the newly created apartment with a success message.
     * If the request fails:
     *   - Redirect the user back to the create form with an error message.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();

        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://api.tomtom.com/search/2/geocode/' . urlencode($request->address) . '.json', [
                    'key' => 'AWAhF6IT1ChO0k28GMmsIysmnTgt0Gpp',
                ]);

        if ($response->successful()) {
            $coordinates = $response->json()['results'][0]['position'];
            $apartment = new Apartment();
            $apartment->fill($data);
            $apartment->latitude = $coordinates['lat'];
            $apartment->longitude = $coordinates['lon'];
            $apartment->save();

            return redirect()->route('apartments.show', $apartment)->with('message', 'Appartamento creato con successo')->with('type', 'success');
        } else {
            return back()->with('message', 'Errore durante la creazione dell\'appartamento. Si prega di riprovare.')->with('type', 'error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $apartment = Apartment::findOrFail($id);

        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return to_route('apartments.index');
    }


    public function toggleVisibility(Apartment $apartment)
    {
        $apartment->is_visible = !$apartment->is_visible;
        $apartment->save();
        return back();
    }
}
