<?php

declare(strict_types=1);

namespace Languages\Global\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Base\Injections\AdditionInjection;
use Tempest\Highlight\Languages\Base\Injections\StrongInjection;
use Tempest\Highlight\Languages\Php\PhpLanguage;

class AdditionInjectionTest extends TestCase
{
    public function test_addition_injection()
    {
        $content = <<<TXT
{+ class Foo +}
TXT;

        $highlighter = new Highlighter();
        $highlighter->setCurrentLanguage(new PhpLanguage());

        $injection = new AdditionInjection();

        $output = $injection->parse($content, $highlighter);

        $this->assertSame(
            trim(<<<TXT
<span class="hl-addition"> <span class="hl-keyword">class</span> <span class="hl-type">Foo</span> </span>
TXT),
            trim($output),
        );
    }
}
