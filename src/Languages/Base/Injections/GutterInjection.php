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
        $lines = preg_split('/\R/u', trim($content, "\n"));

        $gutterNumbers = [];
        $longestGutterNumber = '';

        foreach ($lines as $i => $line) {
            $gutterNumber = $i + $this->startAt;

            if ($icon = ($this->icons[$i + $this->startAt] ?? null)) {
                $gutterNumber .= ' ' . $icon;
            }

            $gutterNumbers[$i] = $gutterNumber;

            if (strlen((string) $longestGutterNumber) < strlen((string) $gutterNumber)) {
                $longestGutterNumber = (string) $gutterNumber;
            }
        }

        $gutterWidth = strlen($longestGutterNumber);

        foreach ($lines as $i => $line) {
            $gutterNumber = $gutterNumbers[$i];

            $hasClasses = $this->classes[$i + $this->startAt] ?? '';
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
