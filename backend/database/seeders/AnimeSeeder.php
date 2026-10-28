<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $anime = [
            [
                'title' => 'Death Note',
                'synopsis' => 'A high school student discovers a supernatural notebook that allows him to kill anyone by writing the victim\'s name while picturing their face. He begins a crusade against criminals, drawing the attention of a legendary detective.',
                'genres' => ['Thriller', 'Supernatural', 'Mystery'],
                'release_year' => 2006,
                'status' => 'completed',
                'rating' => 9.0,
                'poster_url' => 'https://picsum.photos/seed/death-note/300/450',
                'banner_url' => 'https://picsum.photos/seed/death-note-banner/1200/600',
            ],
            [
                'title' => 'Attack on Titan',
                'synopsis' => 'Humanity lives inside cities surrounded by enormous walls due to the Titans, gigantic humanoid creatures who devour humans. A young boy vows to exterminate every Titan after a colossal one breaches the wall.',
                'genres' => ['Action', 'Drama', 'Fantasy'],
                'release_year' => 2013,
                'status' => 'completed',
                'rating' => 9.1,
                'poster_url' => 'https://picsum.photos/seed/attack-on-titan/300/450',
                'banner_url' => 'https://picsum.photos/seed/attack-on-titan-banner/1200/600',
            ],
            [
                'title' => 'Demon Slayer',
                'synopsis' => 'A young boy becomes a demon slayer after his family is slaughtered and his sister is turned into a demon. He embarks on a journey to find a cure for her and to protect others from the same fate.',
                'genres' => ['Action', 'Supernatural', 'Historical'],
                'release_year' => 2019,
                'status' => 'ongoing',
                'rating' => 8.9,
                'poster_url' => 'https://picsum.photos/seed/demon-slayer/300/450',
                'banner_url' => 'https://picsum.photos/seed/demon-slayer-banner/1200/600',
            ],
            [
                'title' => 'Spy x Family',
                'synopsis' => 'A spy forms a makeshift family with an assassin and a telepath to execute a mission, unaware that each of them hides a dangerous secret from the others.',
                'genres' => ['Comedy', 'Slice of Life', 'Action'],
                'release_year' => 2022,
                'status' => 'ongoing',
                'rating' => 8.6,
                'poster_url' => 'https://picsum.photos/seed/spy-x-family/300/450',
                'banner_url' => 'https://picsum.photos/seed/spy-x-family-banner/1200/600',
            ],
            [
                'title' => 'Fullmetal Alchemist: Brotherhood',
                'synopsis' => 'Two brothers search for a Philosopher\'s Stone after an attempt to revive their deceased mother goes terribly wrong, leaving them in damaged physical forms.',
                'genres' => ['Action', 'Adventure', 'Fantasy'],
                'release_year' => 2009,
                'status' => 'completed',
                'rating' => 9.2,
                'poster_url' => 'https://picsum.photos/seed/fullmetal-alchemist/300/450',
                'banner_url' => 'https://picsum.photos/seed/fullmetal-alchemist-banner/1200/600',
            ],
        ];

        foreach ($anime as $item) {
            \App\Models\Anime::create($item);
        }
    }
}
