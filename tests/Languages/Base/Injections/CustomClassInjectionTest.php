<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Base\Injections\CustomClassInjection;

class CustomClassInjectionTest extends TestCase
{
    public function test_custom_class_injection()
    {
        $content = <<<'TXT'
{:hl-property:read:}({:hl-type:int:} $bytes): {:hl-type:string:}
TXT;

        $expected = <<<'TXT'
read(int $bytes): string
TXT;

        $parsed = (new CustomClassInjection())->parse($content, new Highlighter());

        $this->assertSame($expected, $parsed->content);
        $this->assertCount(3, $parsed->tokens);
        $this->assertSame(0, $parsed->tokens[0]->start);
        $this->assertSame(4, $parsed->tokens[0]->end);
        $this->assertSame('hl-property', $parsed->tokens[0]->type->getValue());
        $this->assertSame(5, $parsed->tokens[1]->start);
        $this->assertSame(8, $parsed->tokens[1]->end);
        $this->assertSame('hl-type', $parsed->tokens[1]->type->getValue());
        $this->assertSame(18, $parsed->tokens[2]->start);
        $this->assertSame(24, $parsed->tokens[2]->end);
        $this->assertSame('hl-type', $parsed->tokens[2]->type->getValue());
    }
}
