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
            'title' => 'required|string|unique:apartment|max:30',
            'address' => 'required|string',
            'description' => 'nullable|text',
            'latitude' => 'required|between:-90,90',
            'longitude' => 'required|between:-90,90',
            'rooms' => 'required|max:255',
            'beds' => 'required|max:255',
            'bathrooms' => 'required|max:255',
            'square_meters' => 'required|max:10000',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'is_visible' => 'boolean'
        ];
    }
    public function messages()
    {
        return [

            'title.required' => 'E\' obbligatorio inserire il titolo',
            'title.unique' => 'Questo titolo è gia in uso',
            'title.max' => 'Il titolo non puo superare :max caratteri',
            'address.required' => 'E\' obbligatorio inserire un indirizzo',
            'rooms.required' => 'E\' obbligatorio inserire un numero di stanze',
            'rooms.max' => 'Le stanze non possono essere più di :max',
            'beds.required' => 'E\' obbligatorio inserire un numero di letti',
            'beds.max' => 'I letti non possono essere più di :max',
            'beds.required' => 'E\' obbligatorio inserire un numero di bagni',
            'beds.max' => 'I bagni non possono essere più di :max',
            'square_meters.required' => 'E\' obbligatorio inserire un numero di metri quadrati',
            'square_meters.max' => 'I metri quadrati non possono essere più di :max',
            'image.required' => 'E\' obbligatorio inserire una foto',
            'image.image' => 'Il file deve essere un immagine',
            'image.mimes' => 'Il file deve essere PNG, JPG o JPEG',
            'is_visible.boolean' => 'la visibilità deve essere un booleano'
        ];
    }
}
