<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Media;
use Database\Seeders\Admin\RoleSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            SettingSeeder::class,
            MenuSeeder::class,
        ]);

        $user1 = \App\Models\User::create([
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'email' => 'exempla@exemple.com',
            'phone' => '+229000000000',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_active' => true,

        ]);

        $user2 = \App\Models\User::create([
            'firstname' => 'Abraham',
            'lastname' => 'Allamagbo',
            'email' => 'allamagboa@gmail.com',
            'phone' => '+2290190129340',
            'email_verified_at' => now(),
            'password' => Hash::make('P@ssw0rd123'),
            'remember_token' => Str::random(10),
            'is_active' => true,

        ]);

        $user3 = \App\Models\User::create([
            'firstname' => 'Brice',
            'lastname' => 'Dossa',
            'email' => 'dossabrice@gmail.com',
            'phone' => '+229000000001',
            'email_verified_at' => now(),
            'password' => Hash::make('P@ssw0rd123'),
            'remember_token' => Str::random(10),
            'is_active' => true,

        ]);

        $user4 = \App\Models\User::create([
            'firstname' => 'Hervé',
            'lastname' => 'Dossi',
            'email' => 'dossiherve@gmail.com',
            'phone' => '+2290161615796',
            'email_verified_at' => now(),
            'password' => Hash::make('Abcd12345'),
            'remember_token' => Str::random(10),
            'is_active' => true,
        ]);

        $user1->assignRole('super-admin');
        $user2->assignRole('super-admin');
        $user3->assignRole('super-admin');
        $user4->assignRole('super-admin');

        Media::create([
            'name' => 'president.jpeg',
            'path' => '/medias',
            'size' => 5,
            'type' => 'jpg',
            'base_url' => env('APP_URL', '') . '/storage',
            'thumbnail' => 'thumbnail/president.jpeg',
            'author_id' => 1,
        ]);

        Media::create([
            'name' => 'team-2.jpg',
            'path' => '/medias',
            'size' => 5,
            'type' => 'jpg',
            'base_url' => env('APP_URL', '') . '/storage',
            'thumbnail' => 'thumbnail/team-2.jpg',
            'author_id' => 1,
        ]);

        Media::create([
            'name' => 'team-3.jpg',
            'path' => '/medias',
            'size' => 5,
            'type' => 'jpg',
            'base_url' => env('APP_URL', '') . '/storage',
            'thumbnail' => 'thumbnail/team-3.jpg',
            'author_id' => 1,
        ]);

        Media::create([
            'name' => 'team-4.jpg',
            'path' => '/medias',
            'size' => 5,
            'type' => 'jpg',
            'base_url' => env('APP_URL', '') . '/storage',
            'thumbnail' => 'thumbnail/team-4.jpg',
            'author_id' => 1,
        ]);

        Media::create([
            'name' => 'team_01.jpg',
            'path' => '/medias',
            'size' => 5,
            'type' => 'jpg',
            'base_url' => env('APP_URL', '') . '/storage',
            'thumbnail' => 'thumbnail/team_01.jpg',
            'author_id' => 1,
        ]);

        Media::create([
            'name' => 'team_02.jpg',
            'path' => '/medias',
            'size' => 5,
            'type' => 'jpg',
            'base_url' => env('APP_URL', '') . '/storage',
            'thumbnail' => 'thumbnail/team_02.jpg',
            'author_id' => 1,
        ]);

        Media::create([
            'name' => 'team_03.jpg',
            'path' => '/medias',
            'size' => 5,
            'type' => 'jpg',
            'base_url' => env('APP_URL', '') . '/storage',
            'thumbnail' => 'thumbnail/team_03.jpg',
            'author_id' => 1,
        ]);

        Media::create([
            'name' => 'team_04.jpg',
            'path' => '/medias',
            'size' => 5,
            'type' => 'jpg',
            'base_url' => env('APP_URL', '') . '/storage',
            'thumbnail' => 'thumbnail/team_04.jpg',
            'author_id' => 1,
        ]);

        $this->call([
            CategorySeeder::class,
        ]);

        \App\Models\Article::factory(100)->create();
        // $page = ['mot-du-president', 'historique', 'politique-confidentialite', 'attributions-et-fonctions', 'organisation-et-fonctionnement', 'securite-des-patients', 'accreditation-des-professionnels-de-sante', 'sante-numerique', 'certification-des-etablissements-de-sante'];
        // $title = ['Mot du président', 'Historique de l’A.R.S', 'Mentions légales et gestions des cookies', 'Attributions et fonctions', 'Organisation et fonctionnement', 'Sécurité des patients', 'Accréditation des professionnels de santé', 'Santé numérique', 'Certification des établissements de santé'];
        // foreach ($page as $key => $p) {

        //     \App\Models\Page::create([
        //         'title' => $title[$key],
        //         'author_id' => 1,
        //         'category' => \App\Models\Category::where('type', 'Page')->get()->random()->id,
        //         'poster' => 1,
        //         'is_published' => true,
        //         'slug' => $p,
        //         'publications_count' => 0,
        //         'content' => fake()->paragraphs(5, true),
        //         'content_keywords' => fake()->words(3, true),
        //         'content_description' => fake()->words(3, true),
        //         'tags' => fake()->words(3, true),
        //         'resume' => fake()->sentence(),
        //     ]);
        // }
        \App\Models\Faq::factory(5)->create();

        $this->call([
            DocumentationSeeder::class,
            TeamSeeder::class,
            EventSeeder::class,
        ]);

        // Artisan::call('l5-swagger:generate');
    }
}
