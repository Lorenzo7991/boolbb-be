<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|unique:apartments|max:70',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'rooms' => 'required|integer|min:1|max:50',
            'beds' => 'required|integer|min:1|max:50',
            'bathrooms' => 'required|integer|min:1|max:50',
            'square_meters' => 'required|integer|min:10|max:10000',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'is_visible' => 'boolean',
            'price_per_night' => 'required|integer|min:1',
            'services' => 'required|exists:services,id'

        ];
    }
    public function messages()
    {
        return [

            'title.required' => 'Inserire il titolo',
            'title.unique' => 'Questo titolo è gia in uso',
            'title.max' => 'Il titolo non puo superare :max caratteri',
            'address.required' => 'Inserire un indirizzo',
            'rooms.required' => 'Inserire il numero di stanze',
            'rooms.min' => 'Le stanze non possono essere meno di :min',
            'rooms.max' => 'Le stanze non possono essere più di :max',
            'beds.required' => 'Inserire il numero di letti',
            'beds.min' => 'I letti non possono essere meno di :min',
            'beds.max' => 'I letti non possono essere più di :max',
            'bathrooms.required' => 'Inserire il numero di bagni',
            'bathrooms.min' => 'I bagni non possono essere meno di :min',
            'bathrooms.max' => 'I bagni non possono essere più di :max',
            'square_meters.required' => 'Inserire il numero di metri quadrati',
            'square_meters.min' => 'I metri quadrati non possono essere meno di :min',
            'square_meters.max' => 'I metri quadrati non possono essere più di :max',
            'image.required' => 'Inserire una foto',
            'image.image' => 'Il file deve essere un immagine',
            'image.mimes' => 'Il file deve essere PNG, JPG o JPEG',
            'is_visible.boolean' => 'la visibilità deve essere un booleano',
            'price_per_night.required' => 'Inserire il prezzo per notte',
            'price_per_night.min' => 'Il prezzo per notte non può essere inferiore a :min €',
            'services.required' => 'Devi selezionare almeno 1 servizio',
            'services.*.exists' => 'Il servizio selezionato non è valido'
        ];
    }
}
