<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CampusLocation;

class CampusLocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [

            'Rektorat',

            'Perpustakaan',

            'Masjid Kampus',

            'Auditorium',

            'Fakultas Syariah',

            'Fakultas Tarbiyah',

            'Fakultas Ushuluddin',

            'Fakultas Dakwah',

            'Fakultas Adab',

            'Fakultas Sains dan Teknologi',

            'Fakultas Kedokteran',

            'Pascasarjana',

            'Kantin',

            'Lapangan',

            'Parkiran Utama'

        ];

        foreach ($locations as $location) {

            CampusLocation::create([
                'name' => $location
            ]);

        }
    }
}