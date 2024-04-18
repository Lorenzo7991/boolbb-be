<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        $data = $request->validated();
        $apartment = new Apartment();
        $apartment->fill($data);

        if (Arr::exists($data, 'image')) {
            $extension = $data['image']->extension(); //restituisce l'estensione del file senza punto
            $img_url = Storage::putFileAs('apartment_images', $data['image'], "$apartment->slug.$extension");
            $apartment->image = $img_url;
        }

        $apartment->save();
        return to_route('admin.apartments.show', $apartment)->with('message', 'Appartamento creato con successo')->with('type', 'success');
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
    public function edit(Apartment $apartment)
    {
        return view('admin.apartments.edit', compact('apartment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $data = $request->validated();
        $data['is_visible'] = Arr::exists($data, 'is_visible');


        if (Arr::exists($data, 'image')) {
            if ($apartment->image) Storage::delete($apartment->image); //controlla se c'è già un'immagine e la elimina
            $extension = $data['image']->extension(); //restituisce l'estensione del file senza punto
            $img_url = Storage::putFileAs('apartment_images', $data['image'], "{$data['slug']}.$extension");
            $apartment->image = $img_url;
        }

        $apartment->update($data);
        return to_route('admin.apartments.show', $apartment);
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
