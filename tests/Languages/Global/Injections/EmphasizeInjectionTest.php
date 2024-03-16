<?php

declare(strict_types=1);

namespace Languages\Global\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Global\Injections\EmphasizeInjection;
use Tempest\Highlight\Languages\Php\PhpLanguage;

final class EmphasizeInjectionTest extends TestCase
{
    public function test_emphasize_injection()
    {
        $content = <<<TXT
class {_Foo

test_} extends{_ Bar _}
TXT;

        $highlighter = new Highlighter();
        $highlighter->setCurrentLanguage(new PhpLanguage());

        $injection = new EmphasizeInjection();

        $output = $injection->parse($content, $highlighter);

        $this->assertSame(
            trim(<<<TXT
<span class="hl-keyword">class</span> <span class="hl-em"><span class="hl-type">Foo</span>

test</span> extends<span class="hl-em"> <span class="hl-type">Bar</span> </span>
TXT),
            trim($output),
        );
    }
}
