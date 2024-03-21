<?php

declare(strict_types=1);

namespace Tempest\Highlight;

final class Escape
{
    public const INJECTION_TOKEN = '❿';

    private const TOKENS = [
        '❶' => '&',
        '❷' => '<',
        '❸' => '>',
        '❹' => '"',
        // ❺
        // ❻
        // ❼
        // ❽
        // ❾
        self::INJECTION_TOKEN => '', // injection token
    ];

    public static function injection(string $input): string
    {
        return self::INJECTION_TOKEN . $input . self::INJECTION_TOKEN;
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
            array_values(self::TOKENS),
            array_keys(self::TOKENS),
            $input,
        );
    }

    private static function reverse(string $input): string
    {
        return str_replace(
            array_keys(self::TOKENS),
            array_values(self::TOKENS),
            $input,
        );
    }
}
