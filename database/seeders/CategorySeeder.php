<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'author' => 1,
                'label' => 'Décision',
                'type' => 'Documentation',
            ],
            [
                'author' => 1,
                'label' => 'Réglementation',
                'type' => 'Documentation',
            ],
            [
                'author' => 1,
                'label' => 'Résultats',
                'type' => 'Documentation',
            ],
            [
                'author' => 1,
                'label' => 'Calendrier électoral',
                'type' => 'Documentation',
            ],


            [
                'author' => 1,
                'label' => 'Élections',
                'type' => 'Article',
            ],
            [
                'author' => 1,
                'label' => 'Partis politiques',
                'type' => 'Article',
            ],
            [
                'author' => 1,
                'label' => 'Financement public',
                'type' => 'Article',
            ],
            [
                'author' => 1,
                'label' => 'Institutions',
                'type' => 'Article',
            ],
            [
                'author' => 1,
                'label' => 'Code électoral',
                'type' => 'Article',
            ],


            [
                'author' => 1,
                'label' => 'Élections',
                'type' => 'Video',
            ],
            [
                'author' => 1,
                'label' => 'Partis politiques',
                'type' => 'Video',
            ],
            [
                'author' => 1,
                'label' => 'Financement public',
                'type' => 'Video',
            ],
            [
                'author' => 1,
                'label' => 'Institutions',
                'type' => 'Video',
            ],
            [
                'author' => 1,
                'label' => 'Code électoral',
                'type' => 'Video',
            ],


            [
                'author' => 1,
                'label' => 'Formation & Sensibilisation',
                'type' => 'Event',
            ],
            [
                'author' => 1,
                'label' => 'Élections',
                'type' => 'Event',
            ],
            [
                'author' => 1,
                'label' => 'Coopération',
                'type' => 'Event',
            ],


            [
                'author' => 1,
                'label' => 'page',
                'type' => 'Page',
            ],

            [
                'author' => 1,
                'label' => 'Présidentielle',
                'type' => 'Election',
            ],
            [
                'author' => 1,
                'label' => 'Législative',
                'type' => 'Election',
            ],
            [
                'author' => 1,
                'label' => 'Communale',
                'type' => 'Election',
            ],

        ]);
    }
}
