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
            ['label' => 'Wi-fi', 'icon' => 'connessione'],
            ['label' => 'Posto Macchina', 'icon' => 'posto'],
            ['label' => 'Garage', 'icon' => 'garage'],
            ['label' => 'Piscina', 'icon' => 'piscina'],
            ['label' => 'Portineria', 'icon' => 'porta'],
            ['label' => 'Sauna', 'icon' => 'sauna'],
            ['label' => 'Vista Mare', 'icon' => 'mare'],
            ['label' => 'Cucina', 'icon' => 'cucina'],
            ['label' => 'Aria Condizionata', 'icon' => 'aria'],
        ];

        foreach ($services as $service) {
            $new_service = new Service();

            $new_service->label = $service['label'];
            $new_service->icon = $service['icon'];
            $new_service->save();
        }
    }
}
