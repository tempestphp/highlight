<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Base\Injections\EmphasizeInjection;

final class EmphasizeInjectionTest extends TestCase
{
    public function test_emphasize_injection()
    {
        $content = <<<TXT
{_class Foo_}
TXT;

        $expected = <<<TXT
class Foo
TXT;

        $parsed = (new EmphasizeInjection())->parse($content, new Highlighter());

        $this->assertSame($expected, $parsed->content);
        $this->assertCount(1, $parsed->tokens);
        $this->assertSame(0, $parsed->tokens[0]->start);
        $this->assertSame(9, $parsed->tokens[0]->end);
        $this->assertSame('hl-em', $parsed->tokens[0]->type->getValue());
    }
}
