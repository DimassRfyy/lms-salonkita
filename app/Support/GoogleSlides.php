<?php

namespace App\Support;

class GoogleSlides
{
    /**
     * Extract presentation ID dari berbagai format Google Slides URL
     * 
     * Format yang didukung:
     * - Edit link: https://docs.google.com/presentation/d/{ID}/edit?usp=sharing&ouid=...
     * - Share link: https://docs.google.com/presentation/d/{ID}/edit?usp=sharing
     * - Preview: https://docs.google.com/presentation/d/{ID}/preview
     * - ID langsung: {11-karakter-atau-lebih}
     * 
     * @param string|null $url
     * @return string|null - ID yang di-extract atau null jika invalid
     */
    public static function extractId(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // Jika input langsung ID (hanya alfanumerik dan underscore/dash, 20+ char)
        if (preg_match('/^[a-zA-Z0-9_-]{20,}$/', $url)) {
            return $url;
        }

        // Extract dari URL Google Slides
        // Pattern: /d/{ID}/
        if (preg_match('/\/presentation\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Convert presentation ID menjadi embed URL yang siap ditampilkan
     * 
     * @param string $presentationId
     * @return string - Embed URL
     */
    public static function toEmbedUrl(string $presentationId): string
    {
        // Format embed URL dengan /d/ (bukan /d/e/)
        // Cara ini lebih simple dan tidak butuh published version ID
        return sprintf(
            'https://docs.google.com/presentation/d/%s/embed?start=false&loop=false&delayms=3000',
            $presentationId
        );
    }

    /**
     * Transform dari berbagai format URL menjadi embed URL yang siap pakai
     * 
     * @param string|null $input
     * @return string|null
     */
    public static function transformToEmbedUrl(?string $input): ?string
    {
        if (empty($input)) {
            return null;
        }

        $id = self::extractId($input);
        
        if (empty($id)) {
            return null;
        }

        return self::toEmbedUrl($id);
    }

    /**
     * Validate apakah URL/ID valid
     * 
     * @param string|null $url
     * @return bool
     */
    public static function isValid(?string $url): bool
    {
        return !empty(self::extractId($url));
    }
}
