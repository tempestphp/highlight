<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Base\Injections;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\ParsedInjection;
use Tempest\Highlight\TerminalTheme;

final class GutterInjection implements Injection
{
    private array $icons = [];
    private array $classes = [];

    public function __construct(private readonly int $startAt = 1)
    {
    }

    public function addIcon(int $line, string $token): self
    {
        $this->icons[$line + $this->startAt - 1] = $token;

        return $this;
    }

    public function addClass(int $line, string $class): self
    {
        $this->classes[$line + $this->startAt - 1] = $class;

        return $this;
    }

    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        $icons = $this->icons;
        $classes = $this->classes;

        // Marks belong to the parse that added them; a reused highlighter must start the next parse clean.
        $this->icons = [];
        $this->classes = [];

        $content = trim($content, "\n");

        // Invalid UTF-8 makes the /u split fail; the fallback matches the same line breaks byte by byte.
        $lines = preg_split('/\R/u', $content)
            ?: preg_split('/\r\n|[\n\x0B\x0C\r]|\xC2\x85|\xE2\x80[\xA8\xA9]/', $content);

        $gutterNumbers = [];
        $longestGutterNumber = '';

        foreach ($lines as $i => $line) {
            $gutterNumber = $i + $this->startAt;

            if ($icon = ($icons[$i + $this->startAt] ?? null)) {
                $gutterNumber .= ' ' . $icon;
            }

            $gutterNumbers[$i] = $gutterNumber;

            if (strlen($longestGutterNumber) < strlen((string) $gutterNumber)) {
                $longestGutterNumber = (string) $gutterNumber;
            }
        }

        $gutterWidth = strlen($longestGutterNumber);

        foreach ($lines as $i => $line) {
            $gutterNumber = $gutterNumbers[$i];

            $hasClasses = $classes[$i + $this->startAt] ?? '';
            $gutterClass = 'hl-gutter' . ($hasClasses ? ' ' . $hasClasses : '');

            $lines[$i] = sprintf(
                Escape::tokens('<span class="%s">%s</span>%s%s'),
                $gutterClass,
                str_pad(
                    string: (string) $gutterNumber,
                    length: $gutterWidth,
                    pad_type: STR_PAD_LEFT,
                ),
                $highlighter->getTheme() instanceof TerminalTheme ? ' ' : '',
                $line,
            );
        }

        return new ParsedInjection(implode(PHP_EOL, $lines));
    }
}
