<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['label' => 'Wi-fi', 'icon' => 'https://w7.pngwing.com/pngs/488/305/png-transparent-black-and-white-wifi-wi-fi-computer-icons-wireless-symbol-wifi-miscellaneous-computer-network-mobile-phones-thumbnail.png'],
            ['label' => 'Posto Macchina', 'icon' => 'https://cdn-icons-png.flaticon.com/512/8/8206.png'],
            ['label' => 'Garage', 'icon' => 'https://w7.pngwing.com/pngs/387/328/png-transparent-car-garage-computer-icons-garage-angle-text-rectangle-thumbnail.png'],
            ['label' => 'Piscina', 'icon' => 'https://cdn-icons-png.flaticon.com/512/157/157839.png'],
            ['label' => 'Portineria', 'icon' => 'https://cdn-icons-png.flaticon.com/512/1060/1060203.png'],
            ['label' => 'Sauna', 'icon' => 'https://cdn-icons-png.flaticon.com/512/273/273395.png'],
            ['label' => 'Vista Mare', 'icon' => 'https://static.thenounproject.com/png/2024103-200.png'],
            ['label' => 'Cucina', 'icon' => 'https://cdn-icons-png.flaticon.com/512/72/72118.png'],
            ['label' => 'Aria Condizionata', 'icon' => 'https://cdn-icons-png.flaticon.com/512/114/114735.png'],
        ];

        foreach ($services as $service) {
            $new_service = new Service();

            $new_service->label = $service['label'];
            $new_service->icon = $service['icon'];
            $new_service->save();
        }
    }
}
