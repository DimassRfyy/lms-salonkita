<?php

namespace App\Support;

class Youtube
{
    public static function extractId(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        $candidate = trim($value);

        // Handle direct ID quickly.
        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $candidate) === 1) {
            return $candidate;
        }

        // Parse common URL formats using URL parser first.
        if (filter_var($candidate, FILTER_VALIDATE_URL)) {
            $parts = parse_url($candidate);
            $host = strtolower((string) ($parts['host'] ?? ''));
            $path = trim((string) ($parts['path'] ?? ''), '/');

            if (str_contains($host, 'youtu.be')) {
                $segments = explode('/', $path);
                if (! empty($segments[0]) && preg_match('/^[A-Za-z0-9_-]{11}$/', $segments[0]) === 1) {
                    return $segments[0];
                }
            }

            if (str_contains($host, 'youtube.com') || str_contains($host, 'youtube-nocookie.com')) {
                parse_str((string) ($parts['query'] ?? ''), $query);
                if (! empty($query['v']) && preg_match('/^[A-Za-z0-9_-]{11}$/', (string) $query['v']) === 1) {
                    return (string) $query['v'];
                }

                foreach (['embed', 'shorts', 'live'] as $prefix) {
                    if (str_starts_with($path, $prefix . '/')) {
                        $segment = explode('/', $path)[1] ?? null;
                        if ($segment && preg_match('/^[A-Za-z0-9_-]{11}$/', $segment) === 1) {
                            return $segment;
                        }
                    }
                }
            }
        }

        // Fallback: extract first 11-char token from noisy text.
        $patterns = [
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/shorts\/|youtube\.com\/live\/)([A-Za-z0-9_-]{11})/',
            '/[?&]v=([A-Za-z0-9_-]{11})/',
            '/\b([A-Za-z0-9_-]{11})\b/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $candidate, $matches) === 1) {
                return $matches[1];
            }
        }

        return null;
    }

    public static function embedUrl(?string $value): ?string
    {
        $id = self::extractId($value);

        return $id ? "https://www.youtube.com/embed/{$id}" : null;
    }
}