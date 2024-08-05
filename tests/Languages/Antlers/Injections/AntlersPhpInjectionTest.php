<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Antlers\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Antlers\Injections\AntlersPhpInjection;

class AntlersPhpInjectionTest extends TestCase
{
    #[Test]
    public function test_injection(): void
    {
        $content = '
        {{?
        count($foo)
        ?}}
        ';

        $highlighter = new Highlighter();
        $injection = new AntlersPhpInjection();

        $parsedInjection = $injection->parse($content, $highlighter);

        $this->assertStringContainsString(
            '<span class="hl-property">count',
            $parsedInjection->content,
        );
    }
}
