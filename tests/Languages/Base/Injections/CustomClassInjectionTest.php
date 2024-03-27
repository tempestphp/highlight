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
        $content = <<<TXT
{:hl-a:public class Foo {}:}
TXT;

        $expected = <<<TXT
public class Foo {}
TXT;

        $parsed = (new CustomClassInjection())->parse($content, new Highlighter());

        $this->assertSame($expected, $parsed->content);
        $this->assertCount(1, $parsed->tokens);
        $this->assertSame(0, $parsed->tokens[0]->start);
        $this->assertSame(19, $parsed->tokens[0]->end);
        $this->assertSame('hl-a', $parsed->tokens[0]->type->getValue());
    }
}
