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

    public function test_deletion_not_triggered_by_twig_whitespace_control()
    {
        $content = '{{- block(outerBlocks.content) -}}';

        $parsedInjection = (new DeletionInjection())->parse($content, new Highlighter());

        $this->assertSame($content, $parsedInjection->content);
    }

    public function test_deletion_not_triggered_when_preceded_by_brace()
    {
        $content = '{{- variable -}}';

        $parsedInjection = (new DeletionInjection())->parse($content, new Highlighter());

        $this->assertSame($content, $parsedInjection->content);
    }

    public function test_deletion_not_triggered_by_tag_whitespace_control()
    {
        $content = '{%- if true -%}';

        $parsedInjection = (new DeletionInjection())->parse($content, new Highlighter());

        $this->assertSame($content, $parsedInjection->content);
    }

    public function test_deletion_ending_inside_an_embedded_language(): void
    {
        $content = "{-<script>-}\n    a;\n</script>";

        $expected = <<<'TXT'
<span class="hl-deletion">&lt;<span class="hl-keyword">script</span>&gt;</span>
    a;
&lt;/<span class="hl-keyword">script</span>&gt;
TXT;

        $this->assertSame($expected, (new Highlighter())->parse($content, 'html'));
    }
}
