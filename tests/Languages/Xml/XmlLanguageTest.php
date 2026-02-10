<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Xml;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class XmlLanguageTest extends TestCase
{
    #[DataProvider('provide_highlight_cases')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'xml'),
        );
    }

    public static function provide_highlight_cases(): iterable
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
            ["<ns:tag><tag></tag></ns:tag>", '&lt;<span class="hl-keyword">ns:tag</span>&gt;&lt;<span class="hl-keyword">tag</span>&gt;&lt;/<span class="hl-keyword">tag</span>&gt;&lt;/<span class="hl-keyword">ns:tag</span>&gt;'],
            ['<root xmlns:ns="...">', '&lt;<span class="hl-keyword">root</span> <span class="hl-property">xmlns:ns</span>=&quot;...&quot;&gt;'],
        ];
    }
}
