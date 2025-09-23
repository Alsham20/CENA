<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\RessourcesUtils;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();

        for ($i = 1; $i <= 100; $i++) {
            RessourcesUtils::create([
                'name' => fake()->sentence(),
                'categorie_id' => Category::where('type', 'Documentation')->get()->random()->id,
                'doc_id' => 'doc' . $i,
                'doc_path' => 'https://raw.githubusercontent.com/mozilla/pdf.js/ba2edeae/web/compressed.tracemonkey-pldi-09.pdf',
                'doc_size' => fake()->numberBetween(100, 6000),
                'date_creation' => $date,
            ]);
        }
    }
}
