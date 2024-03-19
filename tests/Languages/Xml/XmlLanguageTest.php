<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Xml;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class XmlLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'xml'),
        );
    }

    public static function data(): array
    {
        return [
            [<<<TXT
<tag attr="">
    <br/>
    
    <!-- comment -->
</tag>
TXT,
                <<<TXT
&lt;<span class="hl-keyword">tag</span> <span class="hl-property">attr</span>=&quot;&quot;&gt;
    &lt;<span class="hl-keyword">br</span>/&gt;
    
    <span class="hl-comment">&lt;!-- comment --&gt;</span>
&lt;/<span class="hl-keyword">tag</span>&gt;
TXT],
        ];
    }
}
