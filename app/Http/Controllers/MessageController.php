<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recupera tutti i messaggi con paginazione
        $apartments = Apartment::whereUserId(Auth::id())->get();
        $apartment_ids = $apartments->pluck('id');
        $messages = Message::whereIn('apartment_id', $apartment_ids)->orderBy('created_at', 'desc')->paginate(5);

        // Passa i dati alla vista
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        // Trova il messaggio con l'ID specificato
        $message = Message::findOrFail($id);
        $apartment_id = $message->apartment_id;
        $apartment = Apartment::findOrFail($apartment_id);
        if ($apartment->user_id !== Auth::id()) {
            return to_route('admin.home')->with('type', 'danger')->with('message', 'Non sei autorizzato ad eseguire questa azione');
        }
        return view('admin.messages.show', compact('message'));
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
    public function destroy(string $id)
    {
        // Trova il messaggio con l'ID specificato e lo elimina
        $message = Message::findOrFail($id);
        $apartment_id = $message->apartment_id;
        $apartment = Apartment::findOrFail($apartment_id);
        if ($apartment->user_id !== Auth::id()) {
            return to_route('admin.home')->with('type', 'danger')->with('message', 'Non sei autorizzato ad eseguire questa azione');
        }
        $message->delete();

        // Redirect alla lista dei messaggi con un messaggio di successo
        return to_route('messages.index')->with('success', 'Messaggio eliminato con successo.');
    }
}
