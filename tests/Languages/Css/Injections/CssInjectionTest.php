<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Css\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Html\Injections\CssInHtmlInjection;
use Tempest\Highlight\Tests\TestsInjections;

class CssInjectionTest extends TestCase
{
    use TestsInjections;

    #[Test]
    public function test_injection(): void
    {
        $content = <<<TXT
        <x-slot name="styles">
            <style>
                body {
                    background-color: red;
                }
            </style>
        </x-slot>
        TXT;

        $expected = <<<TXT
        &lt;x-slot name=&quot;styles&quot;&gt;
            &lt;style&gt;<span class="hl-keyword">
                body </span>{
                    <span class="hl-property">background-color</span>: red;
                }
            &lt;/style&gt;
        &lt;/x-slot&gt;
        TXT;

        $this->assertMatches(
            injection: new CssInHtmlInjection(),
            content: $content,
            expectedContent: $expected,
        );
    }
}
