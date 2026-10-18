<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests;

const VISUAL_VIEWPORT = ['width' => 1280, 'height' => 720];

/**
 * @return array<string, mixed>
 */
function fetchVisualState(string $apiUrl, string $token, string $visualUrl): array
{
    $body = json_encode([
        'url' => $visualUrl,
        'request_type' => ['html'],
        'settle_ms' => 250,
        'viewport' => VISUAL_VIEWPORT,
    ], JSON_THROW_ON_ERROR);

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
            ],
            'content' => $body,
            'ignore_errors' => true,
            'timeout' => 60,
        ],
    ]);

    $response = file_get_contents(rtrim($apiUrl, '/') . '/v1/fetch', false, $context);

    if ($response === false) {
        visualFailure('The browser API request failed.');
    }

    $result = json_decode($response, true, flags: JSON_THROW_ON_ERROR);

    if (! is_array($result) || ($result['status'] ?? null) !== 'completed') {
        visualFailure('The browser API did not complete the page load.');
    }

    $html = $result['response']['html'] ?? null;

    if (! is_string($html)) {
        visualFailure('The browser API response did not contain rendered HTML.');
    }

    if (preg_match('/<script[^>]+id="visual-harness-state"[^>]*>(?<state>.*?)<\/script>/s', $html, $matches) !== 1) {
        visualFailure('The rendered page did not publish its visual state.');
    }

    $state = json_decode($matches['state'], true, flags: JSON_THROW_ON_ERROR);

    if (! is_array($state)) {
        visualFailure('The rendered visual state was not an object.');
    }

    return $state;
}

function visualOrigin(string $url): string
{
    $parts = parse_url($url);

    if (! is_array($parts) || ! isset($parts['scheme'], $parts['host'])) {
        visualFailure('The visual harness URL is invalid.');
    }

    $port = isset($parts['port']) ? ':' . $parts['port'] : '';

    return $parts['scheme'] . '://' . $parts['host'] . $port;
}

function visualFailure(string $message): never
{
    fwrite(STDERR, $message . PHP_EOL);
    exit(1);
}

$apiUrl = getenv('SCRAPER_API_URL');
$token = getenv('SCRAPER_API_TOKEN');
$visualUrl = getenv('HIGHLIGHT_VISUAL_URL');

if (! is_string($apiUrl) || $apiUrl === '' || ! is_string($token) || $token === '' || ! is_string($visualUrl) || $visualUrl === '') {
    visualFailure('Set SCRAPER_API_URL, SCRAPER_API_TOKEN, and HIGHLIGHT_VISUAL_URL.');
}

$first = fetchVisualState($apiUrl, $token, $visualUrl);
$second = fetchVisualState($apiUrl, $token, $visualUrl);
$expectedOrigin = visualOrigin($visualUrl);

if ($first !== $second) {
    visualFailure('The capture state changed between identical requests.');
}

if (($first['target'] ?? null) !== 'rust.md') {
    visualFailure('The browser did not render the Rust fixture.');
}

if ((float) ($first['capture']['width'] ?? 0) !== 1024.0 || ($first['capture']['height'] ?? 0) <= 0) {
    visualFailure('The browser reported an invalid capture rectangle.');
}

if (($first['styles']['colorScheme'] ?? null) !== 'dark'
    || ($first['styles']['captureBackground'] ?? null) !== 'rgb(12, 12, 12)'
    || ($first['styles']['codeBackground'] ?? null) !== 'rgb(12, 12, 12)') {
    visualFailure('The browser did not compute the expected dark styles.');
}

$resourceOrigins = $first['resourceOrigins'] ?? null;

if (! is_array($resourceOrigins) || array_any($resourceOrigins, static fn (mixed $origin): bool => $origin !== $expectedOrigin)) {
    visualFailure('The page loaded a resource from another origin.');
}

fwrite(STDOUT, sprintf(
    "visual harness ok: %s, %.0fx%.0f, %s\n",
    $first['target'],
    $first['capture']['width'],
    $first['capture']['height'],
    $first['styles']['captureBackground'],
));
