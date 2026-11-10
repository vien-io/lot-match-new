<?php

namespace Database\Seeders;

use App\Models\Lot;
use App\Models\LotImage;
use Illuminate\Database\Seeder;

class LotImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [];

        for ($i = 1; $i <= 32; $i++) {
            $images[] = sprintf('sample%02d.jpg', $i);
        }

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