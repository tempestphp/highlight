<?php

declare(strict_types=1);

namespace Languages\Apache;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

final class ApacheLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'apache'),
        );

        $this->assertSame($expected, $highlighter->parse($content, 'apacheconf'));
        $this->assertSame($expected, $highlighter->parse($content, 'htaccess'));
    }

    public static function provide_highlight_cases(): iterable
    {
        return [
            'comments' => [
                <<<'APACHE'
                # This is a comment
                ServerName example.com
                APACHE,
                '<span class="hl-comment"># This is a comment</span>
<span class="hl-keyword">ServerName</span> example.com',
            ],
            'virtual host block' => [
                <<<'APACHE'
                <VirtualHost *:80>
                    ServerName example.com
                    DocumentRoot "/var/www/html"
                </VirtualHost>
                APACHE,
                '&lt;<span class="hl-keyword">VirtualHost</span> *:80&gt;
    <span class="hl-keyword">ServerName</span> example.com
    <span class="hl-keyword">DocumentRoot</span> <span class="hl-value">&quot;/var/www/html&quot;</span>
&lt;/<span class="hl-keyword">VirtualHost</span>&gt;',
            ],
            'rewrite rules' => [
                <<<'APACHE'
                RewriteEngine on
                RewriteCond %{REQUEST_FILENAME} !-f
                RewriteRule ^(.*)$ index.php [L]
                APACHE,
                '<span class="hl-keyword">RewriteEngine</span> <span class="hl-value">on</span>
<span class="hl-keyword">RewriteCond</span> %{REQUEST_FILENAME} !-f
<span class="hl-keyword">RewriteRule</span> ^(.*)$ index.php [L]',
            ],
            'ssl configuration' => [
                <<<'APACHE'
                SSLEngine on
                SSLCertificateFile "/etc/ssl/certs/server.crt"
                APACHE,
                '<span class="hl-keyword">SSLEngine</span> <span class="hl-value">on</span>
<span class="hl-keyword">SSLCertificateFile</span> <span class="hl-value">&quot;/etc/ssl/certs/server.crt&quot;</span>',
            ],
            'directory block with flags' => [
                <<<'APACHE'
                <Directory /var/www>
                    Options All
                    AllowOverride None
                    Require all granted
                </Directory>
                APACHE,
                '&lt;<span class="hl-keyword">Directory</span> /var/www&gt;
    <span class="hl-keyword">Options</span> <span class="hl-value">All</span>
    <span class="hl-keyword">AllowOverride</span> <span class="hl-value">None</span>
    <span class="hl-keyword">Require</span> all <span class="hl-value">granted</span>
&lt;/<span class="hl-keyword">Directory</span>&gt;',
            ],
        ];
    }
}
