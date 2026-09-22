<?php

namespace App\Services\Media;

use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Processes images uploaded through Admin → Pengaturan Website (Settings):
 *
 * - OG Image: always cropped (cover-fit, never stretched) and resized to the
 *   standard Open Graph size of 1200×630 (ratio 1.91:1), then compressed.
 * - Logo: only ever downscaled if it's unusually large, ALWAYS preserving its
 *   original aspect ratio and transparency — never forced into 1200×630.
 *
 * Falls back to storing the untouched upload whenever the GD extension isn't
 * available or the file is an SVG (vector, not something GD can rasterize),
 * so a missing extension never breaks the settings form.
 */
class SettingImageProcessor
{
    public const OG_WIDTH = 1200;

    public const OG_HEIGHT = 630;

    private const LOGO_MAX_WIDTH = 1600;

    public function processOgImage(UploadedFile $file): string
    {
        $source = $this->loadImage($file);

        if ($source === null) {
            return $file->store('settings', 'public');
        }

        $srcWidth = imagesx($source);
        $srcHeight = imagesy($source);
        $targetRatio = self::OG_WIDTH / self::OG_HEIGHT;
        $srcRatio = $srcWidth / $srcHeight;

        if ($srcRatio > $targetRatio) {
            // Source is relatively wider than 1.91:1 → crop the sides.
            $cropHeight = $srcHeight;
            $cropWidth = (int) round($srcHeight * $targetRatio);
            $srcX = (int) round(($srcWidth - $cropWidth) / 2);
            $srcY = 0;
        } else {
            // Source is relatively taller/squarer → crop top & bottom.
            $cropWidth = $srcWidth;
            $cropHeight = (int) round($srcWidth / $targetRatio);
            $srcX = 0;
            $srcY = (int) round(($srcHeight - $cropHeight) / 2);
        }

        $canvas = imagecreatetruecolor(self::OG_WIDTH, self::OG_HEIGHT);

        // og:image is always served as JPEG, so flatten any transparency
        // onto a white background instead of leaving it black/undefined.
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);

        imagecopyresampled(
            $canvas,
            $source,
            0,
            0,
            $srcX,
            $srcY,
            self::OG_WIDTH,
            self::OG_HEIGHT,
            $cropWidth,
            $cropHeight
        );

        $path = 'settings/og-'.Str::random(24).'.jpg';
        $this->saveJpeg($canvas, $path);

        imagedestroy($source);
        imagedestroy($canvas);

        return $path;
    }

    public function processLogo(UploadedFile $file): string
    {
        $extension = strtolower((string) $file->getClientOriginalExtension());

        if ($extension === 'svg') {
            return $file->store('settings', 'public');
        }

        $source = $this->loadImage($file);

        if ($source === null) {
            return $file->store('settings', 'public');
        }

        $width = imagesx($source);
        $height = imagesy($source);

        if ($width > self::LOGO_MAX_WIDTH) {
            $newWidth = self::LOGO_MAX_WIDTH;
            $newHeight = (int) round($height * (self::LOGO_MAX_WIDTH / $width));

            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
            imagefill($resized, 0, 0, $transparent);

            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($source);
            $source = $resized;
        }

        $outputExtension = $extension === 'jpg' ? 'jpeg' : $extension;
        $path = 'settings/logo-'.Str::random(24).'.'.$outputExtension;

        match ($outputExtension) {
            'png' => $this->savePng($source, $path),
            'webp' => $this->saveWebp($source, $path),
            default => $this->saveJpeg($source, $path),
        };

        imagedestroy($source);

        return $path;
    }

    private function loadImage(UploadedFile $file): ?GdImage
    {
        if (! extension_loaded('gd')) {
            return null;
        }

        // getimagesize() also protects against files that merely have an
        // image extension/MIME but aren't actually valid image data.
        $info = @getimagesize($file->getRealPath());

        if ($info === false) {
            return null;
        }

        $path = $file->getRealPath();

        $image = match ($info['mime']) {
            'image/jpeg' => @imagecreatefromjpeg($path),
            'image/png' => @imagecreatefrompng($path),
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            default => false,
        };

        return $image ?: null;
    }

    private function saveJpeg(GdImage $image, string $relativePath): void
    {
        $this->ensureDirectoryFor($relativePath);
        imagejpeg($image, Storage::disk('public')->path($relativePath), 85);
    }

    private function savePng(GdImage $image, string $relativePath): void
    {
        $this->ensureDirectoryFor($relativePath);
        imagesavealpha($image, true);
        imagepng($image, Storage::disk('public')->path($relativePath), 6);
    }

    private function saveWebp(GdImage $image, string $relativePath): void
    {
        if (! function_exists('imagewebp')) {
            $pngPath = Str::replaceLast('.webp', '.png', $relativePath);
            $this->savePng($image, $pngPath);

            return;
        }

        $this->ensureDirectoryFor($relativePath);
        imagesavealpha($image, true);
        imagewebp($image, Storage::disk('public')->path($relativePath), 85);
    }

    private function ensureDirectoryFor(string $relativePath): void
    {
        $dir = dirname(Storage::disk('public')->path($relativePath));

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}
