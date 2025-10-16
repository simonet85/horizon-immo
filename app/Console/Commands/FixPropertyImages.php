<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;

class FixPropertyImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:property-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix broken image URLs in properties (remove conversion URLs that no longer exist)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scanning properties for broken image URLs...');

        $properties = Property::whereNotNull('images')->get();
        $fixed = 0;

        foreach ($properties as $property) {
            if (! $property->images || ! is_array($property->images)) {
                continue;
            }

            $originalCount = count($property->images);

            // Filter out conversion URLs that don't exist
            $filteredImages = array_filter($property->images, function ($url) {
                // Remove URLs that contain /conversions/ and /storage/ (these are Media Library conversion URLs)
                return ! (str_contains($url, '/conversions/') && str_contains($url, '/storage/'));
            });

            // Re-index the array
            $filteredImages = array_values($filteredImages);

            if (count($filteredImages) !== $originalCount) {
                $property->images = $filteredImages;
                $property->save();
                $this->info("Fixed property '{$property->title}' (ID: {$property->id}) - removed ".($originalCount - count($filteredImages)).' broken URLs');
                $fixed++;
            }
        }

        if ($fixed === 0) {
            $this->info('No broken image URLs found.');
        } else {
            $this->info("Fixed {$fixed} properties.");
        }

        return 0;
    }
}
