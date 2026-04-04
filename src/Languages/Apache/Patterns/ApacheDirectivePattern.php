<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Apache\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'ServerName example.com', output: 'ServerName')]
#[PatternTest(input: 'DocumentRoot /var/www/html', output: 'DocumentRoot')]
#[PatternTest(input: '    RewriteRule ^(.*)$ index.php [L]', output: 'RewriteRule')]
#[PatternTest(input: 'Listen 80', output: 'Listen')]
#[PatternTest(input: 'SSLEngine on', output: 'SSLEngine')]
final readonly class ApacheDirectivePattern implements Pattern
{
    use IsPattern;

    private const DIRECTIVES = [
        'ServerRoot', 'Listen', 'LoadModule',
        'ServerAdmin', 'ServerName', 'ServerAlias',
        'DocumentRoot', 'ErrorLog', 'CustomLog', 'LogLevel', 'LogFormat',
        'DirectoryIndex', 'Options', 'AllowOverride',
        'Require', 'Order', 'Allow', 'Deny',
        'Include', 'IncludeOptional',
        'RewriteEngine', 'RewriteCond', 'RewriteRule', 'RewriteBase',
        'SSLEngine', 'SSLCertificateFile', 'SSLCertificateKeyFile', 'SSLCertificateChainFile',
        'ProxyPass', 'ProxyPassReverse', 'ProxyPreserveHost',
        'Header', 'RequestHeader',
        'SetEnv', 'SetEnvIf', 'PassEnv',
        'Redirect', 'RedirectMatch', 'RedirectPermanent',
        'Alias', 'ScriptAlias',
        'AddType', 'AddHandler', 'AddOutputFilterByType',
        'ErrorDocument',
        'Timeout', 'KeepAlive', 'MaxKeepAliveRequests', 'KeepAliveTimeout',
        'AccessFileName', 'DefaultType', 'HostnameLookups',
        'UseCanonicalName', 'ServerSignature', 'ServerTokens',
        'TypesConfig', 'MIMEMagicFile',
        'ExpiresActive', 'ExpiresByType', 'ExpiresDefault',
    ];

    public function getPattern(): string
    {
        $directives = implode('|', self::DIRECTIVES);

        return "/^\s*(?<match>{$directives})\b/m";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
