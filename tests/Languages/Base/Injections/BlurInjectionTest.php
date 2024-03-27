<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Base\Injections\BlurInjection;

final class BlurInjectionTest extends TestCase
{
    public function test_blur_injection()
    {
        $content = <<<TXT
{~class Foo~}
TXT;

        $expected = <<<TXT
class Foo
TXT;

        $parsed = (new BlurInjection())->parse($content, new Highlighter());

        $this->assertSame($expected, $parsed->content);
        $this->assertCount(1, $parsed->tokens);
        $this->assertSame(0, $parsed->tokens[0]->start);
        $this->assertSame(9, $parsed->tokens[0]->end);
        $this->assertSame('hl-blur', $parsed->tokens[0]->type->getValue());
    }
}
