<?php

namespace Database\Seeders;

use App\Models\Lot;
use App\Models\LotImage;
use Illuminate\Database\Seeder;

class LotImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            'sample01.jpeg',
            'sample02.jpeg',
            'sample03.jpeg',
            'sample04.jpeg',
            'sample05.jpeg',
            'sample06.jpeg',
            'sample07.jpeg',
            'sample08.jpeg',
            'sample09.jpeg',
            'sample10.jpeg',
            'sample11.jpeg',
            'sample12.jpeg',
            'sample01.jpg',
            'sample02.jpg',
            'sample03.jpg',
            'sample04.jpg',
            'sample05.jpg',
            'sample01.webp',
            'sample02.webp',
            'sample03.webp',
            'sample04.webp',
            'sample05.webp',
        ];

        $lots = Lot::all();

        $this->command->info('Lots found: ' . $lots->count());

        foreach ($lots as $lot) {
            $selectedImages = collect($images)->random(3);

            foreach ($selectedImages as $image) {
                LotImage::create([
                    'lot_id' => $lot->id,
                    'path' => "storage/lot_images/{$image}",
                ]);
            }
        }

        $this->command->info('Images inserted: ' . LotImage::count());
    }
}