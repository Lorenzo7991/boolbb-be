<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Arr;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_ids = User::pluck('id')->toArray();
        $service_ids = Service::pluck('id')->toArray();

        $apartments = [
            // Appartamenti a Roma
            [
                'title' => 'Appartamento Pantheon',
                'address' => 'Piazza della Rotonda, Roma',
                'description' => 'Accogliente appartamento nel centro storico di Roma, a due passi dal Pantheon.',
                'services' => [1, 4, 6, 8],
                'rooms' => 2,
                'beds' => 3,
                'bathrooms' => 1,
                'square_meters' => 80,
                'latitude' => 41.8986, // Latitudine approssimativa per Roma
                'longitude' => 12.4768, // Longitudine approssimativa per Roma
                'price_per_night' => 100, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],
            [
                'title' => 'Appartamento Colosseo',
                'address' => 'Piazza del Colosseo, Roma',
                'description' => 'Appartamento moderno con vista sul Colosseo, situato nel cuore dell\'antica Roma.',
                'services' => [1, 2, 6, 8, 9],
                'rooms' => 1,
                'beds' => 2,
                'bathrooms' => 1,
                'square_meters' => 60,
                'latitude' => 41.8902, // Latitudine approssimativa per Roma
                'longitude' => 12.4922, // Longitudine approssimativa per Roma
                'price_per_night' => 80, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],
            [
                'title' => 'Appartamento Trastevere',
                'address' => 'Via di Trastevere, Roma',
                'description' => 'Accogliente appartamento nel pittoresco quartiere di Trastevere, con una vivace vita notturna.',
                'services' => [3, 4, 6, 7, 8],
                'rooms' => 3,
                'beds' => 4,
                'bathrooms' => 2,
                'square_meters' => 90,
                'latitude' => 41.8876, // Latitudine approssimativa per Roma
                'longitude' => 12.4674, // Longitudine approssimativa per Roma
                'price_per_night' => 120, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],
            [
                'title' => 'Appartamento Villa Borghese',
                'address' => 'Viale della Villa Borghese, Roma',
                'description' => 'Appartamento elegante vicino ai giardini di Villa Borghese, ideale per una vacanza rilassante.',
                'services' => [1, 2, 3, 4, 5, 6, 8],
                'rooms' => 4,
                'beds' => 6,
                'bathrooms' => 3,
                'square_meters' => 120,
                'latitude' => 41.9125, // Latitudine approssimativa per Roma
                'longitude' => 12.4871, // Longitudine approssimativa per Roma
                'price_per_night' => 150, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],
            [
                'title' => 'Appartamento Piazza Navona',
                'address' => 'Piazza Navona, Roma',
                'description' => 'Appartamento con vista sulla splendida Piazza Navona, nel cuore della vita culturale di Roma.',
                'services' => [1, 2, 4, 5, 6, 8],
                'rooms' => 2,
                'beds' => 3,
                'bathrooms' => 1,
                'square_meters' => 70,
                'latitude' => 41.8992, // Latitudine approssimativa per Roma
                'longitude' => 12.4735, // Longitudine approssimativa per Roma
                'price_per_night' => 110, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],

            // Appartamenti a Firenze
            [
                'title' => 'Appartamento Ponte Vecchio',
                'address' => 'Ponte Vecchio, Firenze',
                'description' => 'Appartamento con vista mozzafiato sul fiume Arno e sul famoso Ponte Vecchio.',
                'services' => [2, 5, 6, 8, 9],
                'rooms' => 3,
                'beds' => 4,
                'bathrooms' => 2,
                'square_meters' => 90,
                'latitude' => 43.7677, // Latitudine approssimativa per Firenze
                'longitude' => 11.2552, // Longitudine approssimativa per Firenze
                'price_per_night' => 130, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],
            [
                'title' => 'Appartamento Duomo',
                'address' => 'Piazza del Duomo, Firenze',
                'description' => 'Appartamento moderno con vista sulla magnifica Cattedrale di Santa Maria del Fiore, nel cuore di Firenze.',
                'services' => [1, 4, 6, 8],
                'rooms' => 2,
                'beds' => 3,
                'bathrooms' => 1,
                'square_meters' => 80,
                'latitude' => 43.7730, // Latitudine approssimativa per Firenze
                'longitude' => 11.2562, // Longitudine approssimativa per Firenze
                'price_per_night' => 100, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],
            [
                'title' => 'Appartamento Pitti',
                'address' => 'Piazza de\' Pitti, Firenze',
                'description' => 'Appartamento elegante nei pressi di Palazzo Pitti, circondato da negozi e ristoranti di lusso.',
                'services' => [2, 4, 5, 6, 7, 9],
                'rooms' => 1,
                'beds' => 2,
                'bathrooms' => 1,
                'square_meters' => 50,
                'latitude' => 43.7662, // Latitudine approssimativa per Firenze
                'longitude' => 11.2484, // Longitudine approssimativa per Firenze
                'price_per_night' => 90, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],
            [
                'title' => 'Appartamento San Lorenzo',
                'address' => 'Piazza di San Lorenzo, Firenze',
                'description' => 'Accogliente appartamento nel vivace quartiere di San Lorenzo, noto per il suo mercato e le sue trattorie.',
                'services' => [1, 3, 5, 6],
                'rooms' => 3,
                'beds' => 4,
                'bathrooms' => 2,
                'square_meters' => 85,
                'latitude' => 43.7742, // Latitudine approssimativa per Firenze
                'longitude' => 11.2499, // Longitudine approssimativa per Firenze
                'price_per_night' => 110, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],
            [
                'title' => 'Appartamento Michelangelo',
                'address' => 'Piazza Michelangelo, Firenze',
                'description' => 'Appartamento con vista panoramica sulla città di Firenze, situato in una delle zone più suggestive della città.',
                'services' => [1, 2, 4, 6, 8, 9],
                'rooms' => 2,
                'beds' => 3,
                'bathrooms' => 1,
                'square_meters' => 75,
                'latitude' => 43.7629, // Latitudine approssimativa per Firenze
                'longitude' => 11.2650, // Longitudine approssimativa per Firenze
                'price_per_night' => 120, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],

            // Appartamenti a Milano
            [
                'title' => 'Appartamento Duomo di Milano',
                'address' => 'Piazza del Duomo, Milano',
                'description' => 'Appartamento lussuoso con vista sulla maestosa Cattedrale di Milano, nel cuore del centro storico.',
                'services' => [1, 3, 4, 5, 6, 8],
                'rooms' => 2,
                'beds' => 3,
                'bathrooms' => 1,
                'square_meters' => 70,
                'latitude' => 45.4641, // Latitudine approssimativa per Milano
                'longitude' => 9.1915, // Longitudine approssimativa per Milano
                'price_per_night' => 180, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],
            [
                'title' => 'Appartamento Navigli',
                'address' => 'Via dei Navigli, Milano',
                'description' => 'Appartamento elegante nel vivace quartiere dei Navigli, famoso per i suoi canali e la sua movida.',
                'services' => [1, 5, 7],
                'rooms' => 1,
                'beds' => 2,
                'bathrooms' => 1,
                'square_meters' => 60,
                'latitude' => 45.4603, // Latitudine approssimativa per Milano
                'longitude' => 9.1808, // Longitudine approssimativa per Milano
                'price_per_night' => 150, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],
            [
                'title' => 'Appartamento Brera',
                'address' => 'Via Brera, Milano',
                'description' => 'Appartamento raffinato nel quartiere artistico di Brera, vicino ai musei e alle gallerie d\'arte.',
                'services' => [1, 4],
                'rooms' => 3,
                'beds' => 4,
                'bathrooms' => 2,
                'square_meters' => 90,
                'latitude' => 45.4716, // Latitudine approssimativa per Milano
                'longitude' => 9.1872, // Longitudine approssimativa per Milano
                'price_per_night' => 160, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],
            [
                'title' => 'Appartamento Porta Nuova',
                'address' => 'Via della Moscova, Milano',
                'description' => 'Appartamento moderno nel quartiere di Porta Nuova, perfetto per chi viaggia per affari o per piacere.',
                'services' => [1, 4, 6, 8, 2, 3],
                'rooms' => 2,
                'beds' => 3,
                'bathrooms' => 1,
                'square_meters' => 75,
                'latitude' => 45.4787, // Latitudine approssimativa per Milano
                'longitude' => 9.1891, // Longitudine approssimativa per Milano
                'price_per_night' => 140, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],
            [
                'title' => 'Appartamento San Siro',
                'address' => 'Viale Achille Papa, Milano',
                'description' => 'Appartamento confortevole nei pressi dello stadio di San Siro, ideale per gli amanti del calcio.',
                'services' => [4, 7, 6, 9],
                'rooms' => 3,
                'beds' => 4,
                'bathrooms' => 2,
                'square_meters' => 85,
                'latitude' => 45.4783, // Latitudine approssimativa per Milano
                'longitude' => 9.1233, // Longitudine approssimativa per Milano
                'price_per_night' => 130, // Prezzo per notte
                'image' => 'apartment_images/test.png', // Aggiungi qui l'URL dell'immagine
            ],
        ];
        foreach ($apartments as $apartment) {
            $new_apartment = new Apartment();
            $new_apartment->title = $apartment['title'];
            $new_apartment->address = $apartment['address'];
            $new_apartment->description = $apartment['description'];
            $new_apartment->rooms = $apartment['rooms'];
            $new_apartment->beds = $apartment['beds'];
            $new_apartment->bathrooms = $apartment['bathrooms'];
            $new_apartment->square_meters = $apartment['square_meters'];
            $new_apartment->latitude = $apartment['latitude'];
            $new_apartment->longitude = $apartment['longitude'];
            $new_apartment->price_per_night = $apartment['price_per_night'];
            $new_apartment->image = $apartment['image'];
            $new_apartment->user_id = Arr::random($user_ids);
            $new_apartment->save();
            $new_apartment->services()->attach($apartment['services']);
        }
    }
}
