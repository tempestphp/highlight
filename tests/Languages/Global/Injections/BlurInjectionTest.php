<?php

declare(strict_types=1);

namespace Languages\Global\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Global\Injections\BlurInjection;
use Tempest\Highlight\Languages\Php\PhpLanguage;

final class BlurInjectionTest extends TestCase
{
    public function test_blur_injection()
    {
        $content = <<<TXT
class {~Foo

test~} extends{~ Bar ~}
TXT;

        $highlighter = new Highlighter();
        $highlighter->setCurrentLanguage(new PhpLanguage());

        $injection = new BlurInjection();

        $output = $injection->parse($content, $highlighter);

        $this->assertSame(
            trim(<<<TXT
<span class="hl-keyword">class</span> <span class="hl-blur"><span class="hl-type">Foo</span>

test</span> extends<span class="hl-blur"> <span class="hl-type">Bar</span> </span>
TXT),
            trim($output),
        );
    }
}
