<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Html;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class HtmlLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'html'),
        );
    }

    public static function data(): array
    {
        return [
            [<<<TXT
<tag attr="">
    <br/>
    
    <!-- comment -->
    
    <style>body {color: red}</style>
    <tag style="background-color: #fff;"></tag>
    <?= foo() ?>
    <?php foo(); ?>
</tag>
TXT,
                <<<TXT
&lt;<span class="hl-keyword">tag</span> <span class="hl-property">attr</span>=&quot;&quot;&gt;
    &lt;<span class="hl-keyword">br</span>/&gt;
    
    <span class="hl-comment">&lt;!-- comment --&gt;</span>
    
    &lt;<span class="hl-keyword">style</span>&gt;<span class="hl-keyword">body </span>{<span class="hl-property">color</span>: red}&lt;/<span class="hl-keyword">style</span>&gt;
    &lt;<span class="hl-keyword">tag</span> <span class="hl-property">style</span>=&quot;<span class="hl-property">background-color</span>: #fff;&quot;&gt;&lt;/<span class="hl-keyword">tag</span>&gt;
    &lt;?= <span class="hl-property">foo</span>() ?&gt;
    &lt;?php <span class="hl-property">foo</span>(); ?&gt;
&lt;/<span class="hl-keyword">tag</span>&gt;
TXT],
        ];
    }
}
