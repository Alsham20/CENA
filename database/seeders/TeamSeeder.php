<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('teams')->insert([
            [
                'lastname' => 'Doe',
                'firstname' => 'John',
                'title' => 'Developer',
                'avatar' => 1,
                'order' => 1,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget aliquam ultricies, nunc sapien ultrices nunc, quis faucibus libero nulla a lectus.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'lastname' => 'Smith',
                'firstname' => 'Jane',
                'title' => 'Project Manager',
                'avatar' => 1,
                'order' => 1,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget aliquam ultricies, nunc sapien ultrices nunc, quis faucibus libero nulla a lectus.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'lastname' => 'Brown',
                'firstname' => 'Charlie',
                'title' => 'Designer',
                'avatar' => 1,
                'order' => 1,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget aliquam ultricies, nunc sapien ultrices nunc, quis faucibus libero nulla a lectus.',

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'lastname' => 'Johnson',
                'firstname' => 'Emily',
                'title' => 'QA Engineer',
                'avatar' => 1,
                'order' => 1,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget aliquam ultricies, nunc sapien ultrices nunc, quis faucibus libero nulla a lectus.',

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'lastname' => 'Taylor',
                'firstname' => 'James',
                'title' => 'Business Analyst',
                'avatar' => 1,
                'order' => 1,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget aliquam ultricies, nunc sapien ultrices nunc, quis faucibus libero nulla a lectus.',

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'lastname' => 'Anderson',
                'firstname' => 'Laura',
                'title' => 'HR Manager',
                'avatar' => 1,
                'order' => 1,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget aliquam ultricies, nunc sapien ultrices nunc, quis faucibus libero nulla a lectus.',

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'lastname' => 'Martinez',
                'firstname' => 'Carlos',
                'title' => 'Sales Executive',
                'avatar' => 1,
                'order' => 1,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget aliquam ultricies, nunc sapien ultrices nunc, quis faucibus libero nulla a lectus.',

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'lastname' => 'Garcia',
                'firstname' => 'Maria',
                'title' => 'Marketing Specialist',
                'avatar' => 1,
                'order' => 1,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec auctor, nisl eget aliquam ultricies, nunc sapien ultrices nunc, quis faucibus libero nulla a lectus.',

                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
