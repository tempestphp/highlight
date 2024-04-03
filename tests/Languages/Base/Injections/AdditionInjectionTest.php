<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Base\Injections\AdditionInjection;

class AdditionInjectionTest extends TestCase
{
    public function test_addition_injection()
    {
        $content = <<<TXT
{+class Foo+}
TXT;

        $expected = <<<TXT
<span class="hl-addition">class Foo</span>
TXT;

        $parsedInjection = (new AdditionInjection())->parse($content, new Highlighter());

        $this->assertSame($expected, Escape::html($parsedInjection->content));
    }
}
