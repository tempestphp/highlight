<?php

declare(strict_types=1);

namespace Tempest\Highlight;

final readonly class Escape
{
    public const string INJECTION_TOKEN = '❿';

    private const array TOKEN_KEYS = ['❶', '❷', '❸', '❹', self::INJECTION_TOKEN];

    private const array TOKEN_VALUES = ['&', '<', '>', '"', ''];

    public static function injection(string $input): string
    {
        return self::INJECTION_TOKEN . $input . self::INJECTION_TOKEN;
    }

    public static function terminal(string $input): string
    {
        return preg_replace(
            ['/❷(.*?)❸/', '/❿/'],
            '',
            $input,
        );
    }

    public static function html(string $input): string
    {
        return self::reverse(
            str_replace(
                ['&', '<', '>', '"'],
                ['&amp;', '&lt;', '&gt;', '&quot;'],
                $input,
            ),
        );
    }

    public static function tokens(string $input): string
    {
        return str_replace(
            self::TOKEN_VALUES,
            self::TOKEN_KEYS,
            $input,
        );
    }

    private static function reverse(string $input): string
    {
        return str_replace(
            self::TOKEN_KEYS,
            self::TOKEN_VALUES,
            $input,
        );
    }
}
