<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Php\Injections\PhpGenericTypeInjection;

class PhpGenericTypeInjectionTest extends TestCase
{
    public function test_generic_type_named_like_theme_markup_does_not_corrupt_earlier_highlights(): void
    {
        $generic = fn (string $type): string => Escape::tokens('<span class="hl-generic">') . $type . Escape::tokens('</span>');

        $parsed = new PhpGenericTypeInjection()->parse(' * Wraps <b> in <span>', new Highlighter());

        $this->assertSame(
            ' * Wraps <' . $generic('b') . '> in <' . $generic('span') . '>',
            $parsed->content,
        );
    }
}
