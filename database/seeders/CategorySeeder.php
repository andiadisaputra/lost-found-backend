<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            [
                'name'=>'Dompet',
                'icon'=>'wallet'
            ],

            [
                'name'=>'HP',
                'icon'=>'smartphone'
            ],

            [
                'name'=>'Laptop',
                'icon'=>'laptop'
            ],

            [
                'name'=>'Tas',
                'icon'=>'backpack'
            ],

            [
                'name'=>'Kunci',
                'icon'=>'key'
            ],

            [
                'name'=>'Dokumen',
                'icon'=>'description'
            ],

            [
                'name'=>'Helm',
                'icon'=>'helmet'
            ],

            [
                'name'=>'Jam Tangan',
                'icon'=>'watch'
            ],

            [
                'name'=>'Perhiasan',
                'icon'=>'diamond'
            ],

            [
                'name'=>'Pakaian',
                'icon'=>'checkroom'
            ],

            [
                'name'=>'Aksesoris',
                'icon'=>'style'
            ],

            [
                'name'=>'Lainnya',
                'icon'=>'category'
            ]

        ];

        Category::insert($categories);
    }
}