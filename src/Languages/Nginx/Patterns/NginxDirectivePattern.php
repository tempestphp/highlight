<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Nginx\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'server {', output: 'server')]
#[PatternTest(input: 'listen 80;', output: 'listen')]
#[PatternTest(input: '    proxy_pass http://backend;', output: 'proxy_pass')]
final readonly class NginxDirectivePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        $directives = implode('|', [
            'server', 'location', 'listen', 'root', 'index', 'proxy_pass',
            'upstream', 'http', 'events', 'worker_processes', 'worker_connections',
            'error_log', 'access_log', 'ssl_certificate', 'ssl_certificate_key',
            'try_files', 'return', 'rewrite', 'if', 'set', 'map', 'include',
            'server_name', 'client_max_body_size', 'keepalive_timeout',
            'gzip', 'gzip_types', 'add_header', 'deny', 'allow',
            'fastcgi_pass', 'fastcgi_param', 'proxy_set_header',
            'proxy_http_version', 'proxy_cache', 'proxy_cache_valid',
            'sendfile', 'tcp_nopush', 'tcp_nodelay', 'types', 'default_type',
            'log_format', 'expires', 'autoindex', 'charset', 'resolver',
            'ssl', 'ssl_protocols', 'ssl_ciphers', 'ssl_prefer_server_ciphers',
            'ssl_session_cache', 'ssl_session_timeout',
            'limit_req', 'limit_req_zone', 'limit_conn', 'limit_conn_zone',
            'geo', 'stub_status',
        ]);

        return "\b(?<match>(?:{$directives}))\b";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
