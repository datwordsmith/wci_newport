<?php

namespace App\Livewire\Admin\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

trait ImageResizer
{
    /**
     * Resize image if it's larger than the target size while maintaining quality
     * 
     * @param UploadedFile $uploadedFile
     * @param int $targetSizeKB Target maximum file size in Kilobytes (default 300 for WhatsApp compatibility)
     * @return UploadedFile
     */
    protected function resizeImageIfNeeded($uploadedFile, $targetSizeKB = 300)
    {
        // Check if GD extension is available
        if (!extension_loaded('gd')) {
            Log::warning('GD extension not available for image resizing');
            return $uploadedFile;
        }

        // If file is already under target size, return as is
        if ($uploadedFile->getSize() <= $targetSizeKB * 1024) {
            return $uploadedFile;
        }

        try {
            $originalPath = $uploadedFile->getPathname();

            // Check if file exists and is readable
            if (!file_exists($originalPath) || !is_readable($originalPath)) {
                Log::warning('Image file not readable: ' . $originalPath);
                return $uploadedFile;
            }

            $imageInfo = getimagesize($originalPath);

            if (!$imageInfo) {
                Log::warning('Invalid image file: ' . $originalPath);
                return $uploadedFile; // Not a valid image, let validation handle it
            }

            $width = $imageInfo[0];
            $height = $imageInfo[1];
            $mimeType = $imageInfo['mime'];

            // Check memory limit before processing large images
            $memoryLimit = ini_get('memory_limit');
            $requiredMemory = ($width * $height * 4); // Rough estimate
            if ($memoryLimit !== '-1' && $requiredMemory > (int)$memoryLimit * 1024 * 1024 * 0.5) {
                Log::warning('Image too large for available memory: ' . $width . 'x' . $height);
                return $uploadedFile;
            }

            // Create image resource based on type
            $sourceImage = null;
            switch ($mimeType) {
                case 'image/jpeg':
                case 'image/jpg':
                    $sourceImage = @imagecreatefromjpeg($originalPath);
                    break;
                case 'image/png':
                    $sourceImage = @imagecreatefrompng($originalPath);
                    break;
                default:
                    Log::warning('Unsupported image format for resizing: ' . $mimeType);
                    return $uploadedFile; // Unsupported format
            }

            if (!$sourceImage) {
                Log::warning('Failed to create image resource from: ' . $originalPath);
                return $uploadedFile;
            }

            // Calculate new dimensions (reduce by 20% each time until under target or max 3 iterations)
            $maxIterations = 4;
            $iteration = 0;
            $quality = 85; // Start with high quality

            do {
                $iteration++;
                $scaleFactor = 1 - ($iteration * 0.15); // Reduce by 15% each iteration
                $newWidth = (int)($width * $scaleFactor);
                $newHeight = (int)($height * $scaleFactor);

                // Ensure minimum dimensions (WhatsApp prefers min 300x200)
                if ($newWidth < 400 || $newHeight < 300) {
                    $newWidth = max(400, $newWidth);
                    $newHeight = max(300, $newHeight);
                }

                // Create new image
                $resizedImage = @imagecreatetruecolor($newWidth, $newHeight);
                if (!$resizedImage) {
                    Log::warning('Failed to create resized image canvas');
                    break;
                }

                // Preserve transparency for PNG
                if ($mimeType === 'image/png') {
                    imagealphablending($resizedImage, false);
                    imagesavealpha($resizedImage, true);
                    $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
                    imagefill($resizedImage, 0, 0, $transparent);
                }

                // Resize the image
                $resizeResult = @imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                if (!$resizeResult) {
                    Log::warning('Failed to resize image');
                    imagedestroy($resizedImage);
                    break;
                }

                // Create temporary file with proper extension
                $extension = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION);
                $tempPath = tempnam(sys_get_temp_dir(), 'resized_image_') . '.' . $extension;

                // Save based on original format
                $success = false;
                switch ($mimeType) {
                    case 'image/jpeg':
                    case 'image/jpg':
                        $success = @imagejpeg($resizedImage, $tempPath, $quality);
                        break;
                    case 'image/png':
                        // PNG compression level (0-9, where 9 is max compression)
                        $pngQuality = 9 - (int)(($quality / 100) * 9);
                        $success = @imagepng($resizedImage, $tempPath, $pngQuality);
                        break;
                }

                imagedestroy($resizedImage);

                if (!$success || !file_exists($tempPath)) {
                    Log::warning('Failed to save resized image to: ' . $tempPath);
                    if (file_exists($tempPath)) {
                        @unlink($tempPath);
                    }
                    break;
                }

                $newSize = filesize($tempPath);

                // If under target size, create new UploadedFile and return
                if ($newSize <= $targetSizeKB * 1024) {
                    $originalName = $uploadedFile->getClientOriginalName();

                    // Create new UploadedFile instance
                    $resizedUploadedFile = new UploadedFile(
                        $tempPath,
                        $originalName,
                        $mimeType,
                        null,
                        true // test mode to avoid file validation issues
                    );

                    imagedestroy($sourceImage);
                    return $resizedUploadedFile;
                }

                // Clean up temp file for next iteration
                if (file_exists($tempPath)) {
                    @unlink($tempPath);
                }

                // Reduce quality for next iteration
                $quality = max(50, $quality - 15);

            } while ($iteration < $maxIterations);

            imagedestroy($sourceImage);

        } catch (\Exception $e) {
            // If resizing fails, return original file
            Log::error('Image resize failed: ' . $e->getMessage(), [
                'file' => $uploadedFile->getClientOriginalName(),
                'size' => $uploadedFile->getSize(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return $uploadedFile; // Return original if resizing failed
    }
}
