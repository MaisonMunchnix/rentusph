<?php

namespace App\Helpers;

use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Encoders\JpegEncoder;

class ImageHelper
{
    /**
     * Industry-standard image normalization:
     *  1. Resize to max 1920px wide (maintains aspect ratio, never upscales small images)
     *  2. Re-encode as JPEG at 82% quality (Airbnb/Google sweet spot — visually lossless)
     *
     * Accepts any upload size. No file-size rejection — the pipeline handles it.
     * A 6000px raw photo (~8MB) becomes ~350–600KB after processing.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $directory  Relative to public_path(), e.g. 'images/cars/gallery'
     * @return string  Saved relative public path
     */
    public static function storeAndCompress(
        \Illuminate\Http\UploadedFile $file,
        string $directory
    ): string {
        $filename = time() . '_' . uniqid() . '.jpg';
        $destDir  = public_path($directory);

        if (! is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $destPath = $destDir . '/' . $filename;

        Image::read($file)
            ->scaleDown(width: 1920) // cap at 1920px, never upscale
            ->encode(new JpegEncoder(quality: 82))
            ->save($destPath);

        return $directory . '/' . $filename;
    }
}
