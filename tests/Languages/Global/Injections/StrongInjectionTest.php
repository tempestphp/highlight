<?php

namespace Tempest\Highlight\Tests\Languages\Global\Injections;

use Tempest\Highlight\Highlighter;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Global\Injections\StrongInjection;
use Tempest\Highlight\Languages\Php\PhpLanguage;

class StrongInjectionTest extends TestCase
{
    public function test_emphasize_injection()
    {
        $content = <<<TXT
class {*Foo

test*} extends{* Bar *}
TXT;

        $highlighter = new Highlighter();
        $highlighter->setCurrentLanguage(new PhpLanguage());

        $injection = new StrongInjection();

        $output = $injection->parse($content, $highlighter);

        $this->assertSame(
            trim(<<<TXT
<span class="hl-keyword">class</span> <span class="hl-strong"><span class="hl-type">Foo</span>

test</span> extends<span class="hl-strong"> <span class="hl-type">Bar</span> </span>
TXT),
            trim($output),
        );
    }
}
