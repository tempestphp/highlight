<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Nginx;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class NginxLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'nginx'),
        );

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'nginxconf'),
        );
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            [<<<'TXT'
# Reverse proxy configuration
server {
    listen 80;
    server_name example.com;

    location / {
        proxy_pass http://backend;
        proxy_set_header Host $host;
    }

    location ~* \.(jpg|css|js)$ {
        expires 30d;
        gzip on;
    }
}
TXT,
            <<<'TXT'
<span class="hl-comment"># Reverse proxy configuration</span>
<span class="hl-keyword">server</span> <span class="hl-operator">{</span>
    <span class="hl-keyword">listen</span> <span class="hl-number">80</span><span class="hl-operator">;</span>
    <span class="hl-keyword">server_name</span> example.com<span class="hl-operator">;</span>

    <span class="hl-keyword">location</span> / <span class="hl-operator">{</span>
        <span class="hl-keyword">proxy_pass</span> <span class="hl-keyword">http</span>://backend<span class="hl-operator">;</span>
        <span class="hl-keyword">proxy_set_header</span> Host <span class="hl-variable">$host</span><span class="hl-operator">;</span>
    <span class="hl-operator">}</span>

    <span class="hl-keyword">location</span> <span class="hl-operator">~*</span> \.(jpg|css|js)$ <span class="hl-operator">{</span>
        <span class="hl-keyword">expires</span> 30d<span class="hl-operator">;</span>
        <span class="hl-keyword">gzip</span> <span class="hl-value">on</span><span class="hl-operator">;</span>
    <span class="hl-operator">}</span>
<span class="hl-operator">}</span>
TXT],
            [<<<'TXT'
upstream backend {
    server 127.0.0.1:8080;
    server 127.0.0.1:8081;
    keepalive_timeout 65;
}
TXT,
            <<<'TXT'
<span class="hl-keyword">upstream</span> backend <span class="hl-operator">{</span>
    <span class="hl-keyword">server</span> <span class="hl-number">127</span>.<span class="hl-number">0</span>.<span class="hl-number">0</span>.<span class="hl-number">1</span>:<span class="hl-number">8080</span><span class="hl-operator">;</span>
    <span class="hl-keyword">server</span> <span class="hl-number">127</span>.<span class="hl-number">0</span>.<span class="hl-number">0</span>.<span class="hl-number">1</span>:<span class="hl-number">8081</span><span class="hl-operator">;</span>
    <span class="hl-keyword">keepalive_timeout</span> <span class="hl-number">65</span><span class="hl-operator">;</span>
<span class="hl-operator">}</span>
TXT],
            [<<<'TXT'
server {
    listen 443 ssl;
    ssl_certificate /etc/ssl/cert.pem;
    ssl_certificate_key /etc/ssl/key.pem;

    add_header X-Frame-Options "SAMEORIGIN";

    if ($request_uri ~* "^/old") {
        return 301 $scheme://example.com/new;
    }
}
TXT,
            <<<'TXT'
<span class="hl-keyword">server</span> <span class="hl-operator">{</span>
    <span class="hl-keyword">listen</span> <span class="hl-number">443</span> <span class="hl-keyword">ssl</span><span class="hl-operator">;</span>
    <span class="hl-keyword">ssl_certificate</span> /etc/<span class="hl-keyword">ssl</span>/cert.pem<span class="hl-operator">;</span>
    <span class="hl-keyword">ssl_certificate_key</span> /etc/<span class="hl-keyword">ssl</span>/key.pem<span class="hl-operator">;</span>

    <span class="hl-keyword">add_header</span> X-Frame-Options <span class="hl-value">&quot;SAMEORIGIN&quot;</span><span class="hl-operator">;</span>

    <span class="hl-keyword">if</span> (<span class="hl-variable">$request_uri</span> <span class="hl-operator">~*</span> <span class="hl-value">&quot;^/old&quot;</span>) <span class="hl-operator">{</span>
        <span class="hl-keyword">return</span> <span class="hl-number">301</span> <span class="hl-variable">$scheme</span>://example.com/new<span class="hl-operator">;</span>
    <span class="hl-operator">}</span>
<span class="hl-operator">}</span>
TXT],
        ];
    }
}
