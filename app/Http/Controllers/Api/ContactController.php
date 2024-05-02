<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function message(Request $request, $apartment_id)
    {
        // Verifica che l'appartamento esista nel database
        $apartment = Apartment::find($apartment_id);
        if (!$apartment) {
            return response()->json(['error' => 'L\'appartamento non esiste'], 404);
        }

        // Recupera l'email dell'utente associato all'appartamento
        $recipient = $apartment->user->email;

        // Recupera i dati del form e li valida
        $data = $request->validate([
            'subject' => 'required|string',
            'text' => 'required|string',
            'name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ]);

        // Associa l'ID dell'appartamento ai dati del messaggio
        $data['apartment_id'] = $apartment_id;

        // Utilizza il modello Message per creare il messaggio
        $message = Message::create($data);

        // Invia il messaggio via email
        $mail = new ContactMessageMail($apartment_id, $data['email'], $data['subject'], $data['text']);
        if (!Mail::to($recipient)->send($mail)) {
            // Se l'invio dell'email fallisce, restituisci un errore JSON
            return response()->json(['error' => 'Impossibile inviare il messaggio'], 500);
        } else {
            // Se l'invio dell'email ha successo, restituisci una conferma JSON
            return response()->json(['message' => 'Messaggio inviato con successo'], 200);
        }
    }
}
