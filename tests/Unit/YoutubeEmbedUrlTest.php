<?php

use App\Support\Youtube;

test('embed url includes origin and branding-minimizing query params', function () {
    $url = Youtube::embedUrl('https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://lms.example.test');

    expect($url)->toStartWith('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?')
        ->and($url)->toContain('modestbranding=1')
        ->and($url)->toContain('rel=0')
        ->and($url)->toContain('origin=' . urlencode('https://lms.example.test'));
});

test('embed url returns null when value is empty', function () {
    expect(Youtube::embedUrl(null))->toBeNull();
});
