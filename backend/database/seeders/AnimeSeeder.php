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
                'title' => 'Neon Blade Chronicle',
                'synopsis' => 'In a fractured cyberpunk metropolis, a young swordsman bonds with a sentient blade to uncover a conspiracy that threatens both the human and digital worlds.',
                'genres' => ['Action', 'Sci-Fi', 'Cyberpunk'],
                'release_year' => 2024,
                'status' => 'ongoing',
                'rating' => 8.7,
                'poster_url' => 'https://example.com/posters/neon-blade.jpg',
                'banner_url' => 'https://example.com/banners/neon-blade.jpg',
            ],
            [
                'title' => 'Starlight Academy',
                'synopsis' => 'Students at a prestigious interstellar academy must compete in planetary survival trials while hiding secrets that could reshape the galaxy.',
                'genres' => ['Adventure', 'School', 'Space'],
                'release_year' => 2023,
                'status' => 'completed',
                'rating' => 8.2,
                'poster_url' => 'https://example.com/posters/starlight-academy.jpg',
                'banner_url' => 'https://example.com/banners/starlight-academy.jpg',
            ],
            [
                'title' => 'Whisper of the Tide',
                'synopsis' => 'A coastal village is haunted by ancient sea spirits, and only a teenage diver can negotiate peace between tides and humanity.',
                'genres' => ['Drama', 'Fantasy', 'Mystery'],
                'release_year' => 2025,
                'status' => 'upcoming',
                'rating' => 9.0,
                'poster_url' => 'https://example.com/posters/whisper-tide.jpg',
                'banner_url' => 'https://example.com/banners/whisper-tide.jpg',
            ],
            [
                'title' => 'Iron Bloom Tournament',
                'synopsis' => 'Fighters pilot giant mechs grown from living metal in a tournament where the winner’s wish is granted by the World Tree.',
                'genres' => ['Action', 'Mecha', 'Tournament'],
                'release_year' => 2024,
                'status' => 'ongoing',
                'rating' => 7.9,
                'poster_url' => 'https://example.com/posters/iron-bloom.jpg',
                'banner_url' => 'https://example.com/banners/iron-bloom.jpg',
            ],
            [
                'title' => 'Midnight Library',
                'synopsis' => 'A librarian drifts between midnight dimensions, returning lost stories to readers who never knew they needed them.',
                'genres' => ['Slice of Life', 'Fantasy', 'Healing'],
                'release_year' => 2023,
                'status' => 'completed',
                'rating' => 8.5,
                'poster_url' => 'https://example.com/posters/midnight-library.jpg',
                'banner_url' => 'https://example.com/banners/midnight-library.jpg',
            ],
        ];

        foreach ($anime as $item) {
            \App\Models\Anime::create($item);
        }
    }
}
