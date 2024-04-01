<?php

namespace Tempest\Highlight\Renderers;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Renderer;

final class GutterRenderer implements Renderer
{
    private array $icons = [];
    private array $classes = [];

    public function __construct(private int $startAt = 1) {}

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

    public function render(string $content): string
    {
        $lines = explode(PHP_EOL, trim($content));

        $gutterNumbers = [];
        $longestGutterNumber = '';

        foreach ($lines as $i => $line) {
            $gutterNumber = $i + $this->startAt;

            if ($icon = ($this->icons[$i + $this->startAt] ?? null)) {
                $gutterNumber .= ' ' . $icon;
            }

            $gutterNumbers[$i] = $gutterNumber;

            if (strlen($longestGutterNumber) < strlen($gutterNumber)) {
                $longestGutterNumber = $gutterNumber;
            }
        }
        
        $gutterWidth = strlen($longestGutterNumber);

        foreach ($lines as $i => $line) {
            $gutterNumber = $gutterNumbers[$i];

            $gutterClass = 'hl-gutter ' . ($this->classes[$i + $this->startAt] ?? '');

            $lines[$i] = sprintf(
                Escape::tokens('<span class="%s">%s</span>%s'),
                $gutterClass,
                str_pad(
                    string: $gutterNumber,
                    length: $gutterWidth,
                    pad_type: STR_PAD_LEFT,
                ),
                $line,
            );
        }

        return implode(PHP_EOL, $lines);
    }
}