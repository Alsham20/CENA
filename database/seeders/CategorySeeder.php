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
                'label' => 'Agriculture',
                'type' => 'Article',
            ],
            [
                'author' => 1,
                'label' => 'Industrie et commerce',
                'type' => 'Article',
            ],
            [
                'author' => 1,
                'label' => 'Éducation',
                'type' => 'Article',
            ],
            [
                'author' => 1,
                'label' => 'Numerique',
                'type' => 'Video',
            ],
            [
                'author' => 1,
                'label' => 'Education',
                'type' => 'Video',
            ],
            [
                'author' => 1,
                'label' => 'Infrastructures et Transports',
                'type' => 'Video',
            ],
            [
                'author' => 1,
                'label' => 'Santé',
                'type' => 'Video',
            ],
            [
                'author' => 1,
                'label' => 'Finance',
                'type' => 'Video',
            ],
            [
                'author' => 1,
                'label' => 'Tourisme',
                'type' => 'Video',
            ],
            [
                'author' => 1,
                'label' => 'Art et culture',
                'type' => 'Event',
            ],
            [
                'author' => 1,
                'label' => 'Musique',
                'type' => 'Event',
            ],
            [
                'author' => 1,
                'label' => 'Sport',
                'type' => 'Event',
            ],
            [
                'author' => 1,
                'label' => 'page',
                'type' => 'Page',
            ],

        ]);
    }
}
