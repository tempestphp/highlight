<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
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
class Foo
TXT;

        $parsed = (new DeletionInjection())->parse($content, new Highlighter());

        $this->assertSame($expected, $parsed->content);
        $this->assertCount(1, $parsed->tokens);
        $this->assertSame(0, $parsed->tokens[0]->start);
        $this->assertSame(9, $parsed->tokens[0]->end);
        $this->assertSame('hl-deletion', $parsed->tokens[0]->type->getValue());
    }
}
