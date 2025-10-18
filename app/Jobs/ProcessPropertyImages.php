<?php

namespace App\Jobs;

use App\Models\Property;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;

class ProcessPropertyImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public $tries = 3;

    /**
     * The maximum number of seconds the job can run.
     */
    public $timeout = 300; // 5 minutes

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Property $property,
        public array $imagePaths
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Processing {count} images for property #{id}', [
            'count' => count($this->imagePaths),
            'id' => $this->property->id,
        ]);

        foreach ($this->imagePaths as $imagePath) {
            try {
                // Vérifier que le fichier existe
                if (! file_exists($imagePath)) {
                    Log::warning('Image file not found: {path}', ['path' => $imagePath]);

                    continue;
                }

                // Ajouter l'image à la collection media
                $this->property
                    ->addMedia($imagePath)
                    ->toMediaCollection('images');

                // Supprimer le fichier temporaire après traitement
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                Log::info('Image processed successfully for property #{id}', [
                    'id' => $this->property->id,
                    'path' => basename($imagePath),
                ]);
            } catch (FileDoesNotExist $e) {
                Log::error('File does not exist for property #{id}: {error}', [
                    'id' => $this->property->id,
                    'path' => $imagePath,
                    'error' => $e->getMessage(),
                ]);
            } catch (Exception $e) {
                Log::error('Failed to process image for property #{id}: {error}', [
                    'id' => $this->property->id,
                    'path' => $imagePath,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                // Re-throw pour permettre les tentatives de retry
                throw $e;
            }
        }

        Log::info('All images processed for property #{id}', [
            'id' => $this->property->id,
            'total' => $this->property->getMedia('images')->count(),
        ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(Exception $exception): void
    {
        Log::error('Job ProcessPropertyImages failed for property #{id}: {error}', [
            'id' => $this->property->id,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);

        // Optionnel : Envoyer une notification à l'admin
        // Notification::route('mail', config('mail.from.address'))
        //     ->notify(new ImageProcessingFailed($this->property, $exception));
    }
}
