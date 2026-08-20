<?php

namespace App\Support;

class GoogleSlides
{
    /**
     * Extract file / presentation ID dari berbagai format URL
     * 
     * Format yang didukung:
     * - Google Drive File/PDF: https://drive.google.com/file/d/{ID}/view?usp=sharing
     * - Google Drive Preview: https://drive.google.com/file/d/{ID}/preview
     * - Google Drive Open ID: https://drive.google.com/open?id={ID}
     * - Google Slides Edit: https://docs.google.com/presentation/d/{ID}/edit?usp=sharing
     * - Google Slides Preview/Embed: https://docs.google.com/presentation/d/{ID}/preview
     * - Google Docs: https://docs.google.com/document/d/{ID}/edit
     * - ID langsung: {20-karakter-atau-lebih}
     * 
     * @param string|null $url
     * @return string|null - ID yang di-extract atau null jika invalid
     */
    public static function extractId(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        // Jika input langsung ID (hanya alfanumerik dan underscore/dash, 20+ char)
        if (preg_match('/^[a-zA-Z0-9_-]{20,}$/', $url)) {
            return $url;
        }

        // Extract dari URL Google Slides: /presentation/d/{ID}
        if (preg_match('/\/presentation\/d\/([a-zA-Z0-9_-]+)/i', $url, $matches)) {
            return $matches[1];
        }

        // Extract dari URL Google Drive File (PDF/PPT/dll): /file/d/{ID}
        if (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/i', $url, $matches)) {
            return $matches[1];
        }

        // Extract dari URL Google Docs: /document/d/{ID}
        if (preg_match('/docs\.google\.com\/document\/d\/([a-zA-Z0-9_-]+)/i', $url, $matches)) {
            return $matches[1];
        }

        // Extract dari parameter query Google Drive ?id={ID}
        if (preg_match('/[?&]id=([a-zA-Z0-9_-]+)/i', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Cek apakah URL merupakan file Google Drive (misal PDF atau file upload)
     */
    public static function isDriveFile(?string $url): bool
    {
        if (empty($url)) {
            return false;
        }

        return (bool) preg_match('/drive\.google\.com\/file\/d\/|[?&]id=/i', $url);
    }

    /**
     * Cek apakah URL merupakan Google Slides
     */
    public static function isGoogleSlides(?string $url): bool
    {
        if (empty($url)) {
            return false;
        }

        return (bool) preg_match('/\/presentation\/d\//i', $url);
    }

    /**
     * Cek apakah URL merupakan Google Docs
     */
    public static function isGoogleDoc(?string $url): bool
    {
        if (empty($url)) {
            return false;
        }

        return (bool) preg_match('/docs\.google\.com\/document\/d\//i', $url);
    }

    /**
     * Convert presentation ID menjadi embed URL Google Slides
     * 
     * @param string $presentationId
     * @return string - Embed URL
     */
    public static function toEmbedUrl(string $presentationId): string
    {
        return sprintf(
            'https://docs.google.com/presentation/d/%s/embed?start=false&loop=false&delayms=3000',
            $presentationId
        );
    }

    /**
     * Convert Drive file ID menjadi preview/embed URL
     * 
     * @param string $fileId
     * @return string - Preview URL
     */
    public static function toDrivePreviewUrl(string $fileId): string
    {
        return sprintf(
            'https://drive.google.com/file/d/%s/preview',
            $fileId
        );
    }

    /**
     * Transform dari berbagai format URL (Drive PDF, Slides, Docs) menjadi embed URL yang siap pakai
     * 
     * @param string|null $input
     * @return string|null
     */
    public static function transformToEmbedUrl(?string $input): ?string
    {
        if (empty($input)) {
            return null;
        }

        $input = trim($input);
        $id = self::extractId($input);
        
        if (empty($id)) {
            return null;
        }

        if (self::isGoogleSlides($input)) {
            return self::toEmbedUrl($id);
        }

        if (self::isGoogleDoc($input)) {
            return sprintf('https://docs.google.com/document/d/%s/preview', $id);
        }

        // Default untuk Google Drive File (PDF/PPT/dll) atau jika input berupa ID
        return self::toDrivePreviewUrl($id);
    }

    /**
     * Validate apakah URL/ID valid untuk Google Slides atau Google Drive PDF/File
     * 
     * @param string|null $url
     * @return bool
     */
    public static function isValid(?string $url): bool
    {
        return !empty(self::extractId($url));
    }
}
