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
            ['label' => 'Wi-fi', 'icon' => 'fa-solid fa-wifi'],
            ['label' => 'Posto Macchina', 'icon' => 'fa-solid fa-square-parking'],
            ['label' => 'Garage', 'icon' => 'fa-solid fa-warehouse'],
            ['label' => 'Piscina', 'icon' => 'fa-solid fa-water-ladder'],
            ['label' => 'Portineria', 'icon' => 'fa-solid fa-bell-concierge'],
            ['label' => 'Sauna', 'icon' => 'fa-solid fa-temperature-arrow-up'],
            ['label' => 'Vista Mare', 'icon' => 'fa-solid fa-water'],
            ['label' => 'Cucina', 'icon' => 'fa-solid fa-kitchen-set'],
            ['label' => 'Aria Condizionata', 'icon' => 'fa-solid fa-wind'],
        ];

        foreach ($services as $service) {
            $new_service = new Service();

            $new_service->label = $service['label'];
            $new_service->icon = $service['icon'];
            $new_service->save();
        }
    }
}
