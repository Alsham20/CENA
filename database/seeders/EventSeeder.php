<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();

        DB::table('evenements')->insert([
            [
                'id' => 1,
                'event_name' => 'Tech Conference 2024',
                'place' => 'San Francisco, CA',
                'event_description' => 'Annual technology conference with keynotes from industry leaders.',
                'event_start' => $date,
                'event_end' => $date->copy()->addHours(2),
                'author' => 1,
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id' => 2,
                'event_name' => 'Health & Wellness Expo',
                'place' => 'New York, NY',
                'event_description' => 'Expo focused on health and wellness products and services.',
                'event_start' => $date->copy()->addDay(),
                'event_end' => $date->copy()->addDay()->addHours(3),
                'author' => 1,
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id' => 3,
                'event_name' => 'Business Summit 2024',
                'place' => 'Chicago, IL',
                'event_description' => 'Summit for business professionals to network and share insights.',
                'event_start' => $date->copy()->addDays(2),
                'event_end' => $date->copy()->addDays(2)->addHours(4),
                'author' => 1,
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id' => 4,
                'event_name' => 'Art & Culture Festival',
                'place' => 'Los Angeles, CA',
                'event_description' => 'Festival celebrating art and culture from around the world.',
                'event_start' => $date->copy()->addDays(3),
                'event_end' => $date->copy()->addDays(3)->addHours(5),
                'author' => 1,
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id' => 5,
                'event_name' => 'Startup Pitch Night',
                'place' => 'Austin, TX',
                'event_description' => 'Evening event where startups pitch their ideas to investors.',
                'event_start' => $date->copy()->addDays(4),
                'event_end' => $date->copy()->addDays(4)->addHours(6),
                'author' => 1,
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id' => 6,
                'event_name' => 'Food Truck Festival',
                'place' => 'Seattle, WA',
                'event_description' => 'Festival featuring a variety of food trucks from across the city.',
                'event_start' => $date->copy()->addDays(5),
                'event_end' => $date->copy()->addDays(5)->addHours(7),
                'author' => 1,
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id' => 7,
                'event_name' => 'Tech Startup Meetup',
                'place' => 'Boston, MA',
                'event_description' => 'Meetup for tech startups to network and share ideas.',
                'event_start' => $date->copy()->addDays(6),
                'event_end' => $date->copy()->addDays(6)->addHours(8),
                'author' => 1,
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id' => 8,
                'event_name' => 'Fashion Week 2024',
                'place' => 'Miami, FL',
                'event_description' => 'Fashion week event showcasing the latest trends.',
                'event_start' => $date->copy()->addDays(7),
                'event_end' => $date->copy()->addDays(7)->addHours(9),
                'author' => 1,
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id' => 9,
                'event_name' => 'Book Fair',
                'place' => 'Denver, CO',
                'event_description' => 'Fair featuring books from local and national authors.',
                'event_start' => $date->copy()->addDays(8),
                'event_end' => $date->copy()->addDays(8)->addHours(10),
                'author' => 1,
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'id' => 10,
                'event_name' => 'Music Festival',
                'place' => 'Nashville, TN',
                'event_description' => 'Festival with performances from various music artists.',
                'event_start' => $date->copy()->addDays(9),
                'event_end' => $date->copy()->addDays(9)->addHours(11),
                'author' => 1,
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ]);
    }
}
