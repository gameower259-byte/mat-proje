<?php

declare(strict_types=1);

function enforceSecurityHeaders(): void
{
    header('X-Frame-Options: DENY');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
}

function enforceRateLimit(string $bucket, int $limit, int $windowSeconds): void
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    $key = hash('sha256', $bucket . '|' . $ip . '|' . substr($userAgent, 0, 120));
    $file = sys_get_temp_dir() . "/portal-rate-{$key}.json";
    $now = time();

    $timestamps = [];
    if (is_file($file)) {
        $content = file_get_contents($file);
        $decoded = json_decode($content ?: '[]', true);
        if (is_array($decoded)) {
            $timestamps = $decoded;
        }
    }

    $timestamps = array_values(array_filter(
        $timestamps,
        static fn(int $timestamp): bool => $timestamp > ($now - $windowSeconds)
    ));

    if (count($timestamps) >= $limit) {
        http_response_code(429);
        header('Retry-After: ' . $windowSeconds);
        echo 'Çok fazla istek. Lütfen kısa bir süre sonra tekrar deneyin.';
        exit;
    }

    $timestamps[] = $now;
    file_put_contents($file, json_encode($timestamps));
}
