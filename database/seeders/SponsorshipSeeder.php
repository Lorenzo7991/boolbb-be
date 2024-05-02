<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsorships = [
            ['label' => 'gold', 'price' => '9.99', 'duration' => '144'],
            ['label' => 'silver', 'price' => '5.99', 'duration' => '72'],
            ['label' => 'bronze', 'price' => '2.99', 'duration' => '24']
        ];

        foreach ($sponsorships as $sponsorship) {
            $new_sponsorship = new Sponsorship();
            $new_sponsorship->fill($sponsorship);
            $new_sponsorship->save();
        }
    }
}
