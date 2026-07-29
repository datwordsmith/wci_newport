<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\NewsUpdate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Livewire\Admin\Traits\ImageResizer;

class CompressExistingImages extends Command
{
    use ImageResizer;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:compress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compress all existing event and news images to be under 300KB for social sharing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting image compression process...');

        $this->compressEvents();
        $this->compressNews();

        $this->info('Image compression completed successfully!');
    }

    private function compressEvents()
    {
        $events = Event::whereNotNull('poster')->get();
        
        $this->info('Processing ' . $events->count() . ' events...');
        
        $count = 0;
        foreach ($events as $event) {
            $disk = Storage::disk('public');
            if ($disk->exists($event->poster)) {
                $absolutePath = $disk->path($event->poster);
                $size = filesize($absolutePath);
                
                if ($size > 300 * 1024) {
                    $this->line("Compressing event poster: {$event->title} (" . round($size / 1024) . "KB)");
                    
                    $file = new UploadedFile(
                        $absolutePath,
                        basename($absolutePath),
                        mime_content_type($absolutePath),
                        null,
                        true // test mode
                    );

                    $processedFile = $this->resizeImageIfNeeded($file, 300);
                    
                    if ($processedFile !== $file) {
                        // Store the new compressed file
                        $newPath = $processedFile->store('posters', 'public');
                        
                        // Delete the old uncompressed file
                        $disk->delete($event->poster);
                        
                        // Update DB
                        $event->update(['poster' => $newPath]);
                        $count++;
                    }
                }
            }
        }
        $this->info("Compressed {$count} event posters.");
    }

    private function compressNews()
    {
        $news = NewsUpdate::whereNotNull('image_path')->get();
        
        $this->info('Processing ' . $news->count() . ' news updates...');
        
        $count = 0;
        foreach ($news as $item) {
            $disk = Storage::disk('public');
            if ($disk->exists($item->image_path)) {
                $absolutePath = $disk->path($item->image_path);
                $size = filesize($absolutePath);
                
                if ($size > 300 * 1024) {
                    $this->line("Compressing news image: {$item->title} (" . round($size / 1024) . "KB)");
                    
                    $file = new UploadedFile(
                        $absolutePath,
                        basename($absolutePath),
                        mime_content_type($absolutePath),
                        null,
                        true // test mode
                    );

                    $processedFile = $this->resizeImageIfNeeded($file, 300);
                    
                    if ($processedFile !== $file) {
                        // Store the new compressed file
                        $newPath = $processedFile->store('news-images', 'public');
                        
                        // Delete the old uncompressed file
                        $disk->delete($item->image_path);
                        
                        // Update DB
                        $item->update(['image_path' => $newPath]);
                        $count++;
                    }
                }
            }
        }
        $this->info("Compressed {$count} news update images.");
    }
}
