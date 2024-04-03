<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Base\Injections\DeletionInjection;

class DeletionInjectionTest extends TestCase
{
    public function test_deletion_injection()
    {
        $content = <<<TXT
{-class Foo-}
TXT;

        $expected = <<<TXT
<span class="hl-deletion">class Foo</span>
TXT;

        $parsedInjection = (new DeletionInjection())->parse($content, new Highlighter());

        $this->assertSame($expected, Escape::html($parsedInjection->content));
    }
}
