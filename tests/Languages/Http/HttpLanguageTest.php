<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Http;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Http\HttpLanguage;

class HttpLanguageTest extends TestCase
{
    #[DataProvider('provide_highlighting_cases')]
    public function test_highlighting(string $content, string $expected)
    {
        $highlighter = new Highlighter();
        $highlighter->addLanguage(new HttpLanguage());

        $this->assertSame(
            trim($expected),
            trim($highlighter->parse($content, 'http'))
        );
    }

    public static function provide_highlighting_cases(): iterable
    {
        return [
            // Standard Request Line
            [
                'GET /index.html HTTP/1.1',
                '<span class="hl-keyword">GET</span> <span class="hl-value">/index.html</span> <span class="hl-property">HTTP/1.1</span>',
            ],
            // Request with absolute URL
            [
                'POST https://api.tempest.php/v1/data HTTP/2',
                '<span class="hl-keyword">POST</span> <span class="hl-value">https://api.tempest.php/v1/data</span> <span class="hl-property">HTTP/2</span>',
            ],
            // Response Line
            [
                'HTTP/1.1 200 OK',
                '<span class="hl-property">HTTP/1.1</span> <span class="hl-number">200</span> OK',
            ],
            // Headers
            [
                'Host: localhost
Content-Type: application/json
X-Custom-Header: value',
                '<span class="hl-attribute">Host</span>: localhost
<span class="hl-attribute">Content-Type</span>: application/json
<span class="hl-attribute">X-Custom-Header</span>: value',
            ],
            // Full Request Example
            [
                "DELETE /user/1 HTTP/1.1\nHost: api.com\nAccept: */*",
                "<span class=\"hl-keyword\">DELETE</span> <span class=\"hl-value\">/user/1</span> <span class=\"hl-property\">HTTP/1.1</span>\n<span class=\"hl-attribute\">Host</span>: api.com\n<span class=\"hl-attribute\">Accept</span>: */*",
            ],
            // Error Response
            [
                'HTTP/2 404 Not Found',
                '<span class="hl-property">HTTP/2</span> <span class="hl-number">404</span> Not Found',
            ],
            // HTTP/3 response (highlight.js http3 fixture)
            [
                'HTTP/3 200',
                '<span class="hl-property">HTTP/3</span> <span class="hl-number">200</span>',
            ],
            // Three-digit header values must NOT be highlighted as a status code
            [
                "HTTP/2 301\ncontent-length: 220",
                "<span class=\"hl-property\">HTTP/2</span> <span class=\"hl-number\">301</span>\n<span class=\"hl-attribute\">content-length</span>: 220",
            ],
            // Comments / request separators
            [
                '### Get users',
                '<span class="hl-comment">### Get users</span>',
            ],
        ];
    }
}
