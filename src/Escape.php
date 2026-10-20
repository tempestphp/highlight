<?php

declare(strict_types=1);

namespace Tempest\Highlight;

final readonly class Escape
{
    public const string INJECTION_TOKEN = '❿';

    public const array TOKEN_KEYS = ['❶', '❷', '❸', '❹', self::INJECTION_TOKEN];

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

    /**
     * Escapes HTML special characters and turns tokens back into raw markup in a single pass.
     * The escape and token keys are disjoint and strtr never rescans replaced text,
     * so this equals escaping first and reversing the tokens afterwards.
     */
    private const array HTML_MAP = [
        '&' => '&amp;',
        '<' => '&lt;',
        '>' => '&gt;',
        '"' => '&quot;',
        '❶' => '&',
        '❷' => '<',
        '❸' => '>',
        '❹' => '"',
        self::INJECTION_TOKEN => '',
    ];

    public static function html(string $input): string
    {
        return strtr($input, self::HTML_MAP);
    }

    public static function tokens(string $input): string
    {
        return str_replace(
            self::TOKEN_VALUES,
            self::TOKEN_KEYS,
            $input,
        );
    }
}
