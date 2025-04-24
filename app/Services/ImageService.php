<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ImageService
{
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];
    private const MAX_FILE_SIZE = 10240; // 10MB
    private const THUMBNAIL_WIDTH = 300;
    private const THUMBNAIL_HEIGHT = 200;

    public function store(UploadedFile $file): array
    {
        $this->validate($file);

        $filename = $this->generateFilename($file);
        $path = $file->storeAs('uploads/images', $filename, 'public');
        $thumbnailPath = $this->createThumbnail($file, $filename);

        return [
            'filename' => $filename,
            'path' => $path,
            'thumbnail_path' => $thumbnailPath,
        ];
    }

    private function validate(UploadedFile $file): void
    {
        if (!in_array($file->getClientOriginalExtension(), self::ALLOWED_EXTENSIONS)) {
            throw new \InvalidArgumentException('Invalid file type. Allowed types: ' . implode(', ', self::ALLOWED_EXTENSIONS));
        }

        if ($file->getSize() > self::MAX_FILE_SIZE * 1024) {
            throw new \InvalidArgumentException('File size exceeds maximum limit of ' . self::MAX_FILE_SIZE . 'KB');
        }

        if (!$this->isValidImage($file)) {
            throw new \InvalidArgumentException('Invalid image file');
        }
    }

    private function isValidImage(UploadedFile $file): bool
    {
        try {
            $image = Image::make($file);
            return $image->width() > 0 && $image->height() > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function generateFilename(UploadedFile $file): string
    {
        return Str::random(40) . '.' . $file->getClientOriginalExtension();
    }

    private function createThumbnail(UploadedFile $file, string $filename): string
    {
        $image = Image::make($file);
        $image->fit(self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT);

        $thumbnailPath = 'uploads/thumbnails/' . $filename;
        Storage::disk('public')->put($thumbnailPath, (string) $image->encode());

        return $thumbnailPath;
    }

    public function delete(string $path, string $thumbnailPath): void
    {
        Storage::disk('public')->delete([$path, $thumbnailPath]);
    }
} 