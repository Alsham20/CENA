<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('activities')->insert([
            [
                'author' => 1,
                'label' => 'Communiqués',
                'type' => 'Article',
            ],
            [
                'author' => 1,
                'label' => 'Comptes rendus',
                'type' => 'Article',
            ],
            [
                'author' => 1,
                'label' => 'Audiences',
                'type' => 'Article',
            ],
            [
                'author' => 1,
                'label' => 'Tutoriels',
                'type' => 'Article',
            ],


            [
                'author' => 1,
                'label' => 'Communiqués',
                'type' => 'Video',
            ],
            [
                'author' => 1,
                'label' => 'Comptes rendus',
                'type' => 'Video',
            ],
            [
                'author' => 1,
                'label' => 'Audiences',
                'type' => 'Video',
            ],
            [
                'author' => 1,
                'label' => 'Tutoriels',
                'type' => 'Video',
            ],

        ]);
    }
}
