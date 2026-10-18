<?php

declare(strict_types=1);

namespace Tempest\Highlight;

final readonly class Escape
{
    public const string INJECTION_TOKEN = '❿';

    public const array TOKEN_KEYS = ['❶', '❷', '❸', '❹', self::INJECTION_TOKEN];

    private const array TOKEN_VALUES = ['&', '<', '>', '"', ''];

    private const array SOURCE_TOKEN_TERMINATORS = [
        "\u{E010}",
        "\u{E011}",
        "\u{E012}",
        "\u{E013}",
        "\u{E014}",
    ];

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

    /**
     * @return array{string, array<string, string>}
     */
    public static function protectReservedTokens(string $input): array
    {
        $replacements = self::createReservedTokenReplacements($input);

        return [
            strtr($input, $replacements),
            array_flip($replacements),
        ];
    }

    /**
     * @param array<string, string> $replacements
     */
    public static function restoreReservedTokens(string $input, array $replacements): string
    {
        return strtr($input, $replacements);
    }

    /**
     * @return array<string, string>
     */
    private static function createReservedTokenReplacements(string $input): array
    {
        $delimiter = "\u{E000}";
        $padding = "\u{E001}";
        $nonce = 1;

        do {
            $replacements = [];

            foreach (self::TOKEN_KEYS as $index => $token) {
                $replacements[$token] = $delimiter
                    . str_repeat($padding, $nonce)
                    . self::SOURCE_TOKEN_TERMINATORS[$index];
            }

            ++$nonce;
        } while (array_any($replacements, static fn (string $replacement): bool => str_contains($input, $replacement)));

        return $replacements;
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
