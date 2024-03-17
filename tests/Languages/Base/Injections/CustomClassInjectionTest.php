<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Base\Injections\CustomClassInjection;
use Tempest\Highlight\Languages\Php\PhpLanguage;

class CustomClassInjectionTest extends TestCase
{
    public function test_custom_class_injection()
    {
        $content = <<<TXT
{`hl-a`public class Foo {}`}
{`hl-b`public class Bar {}`}
TXT;

        $highlighter = new Highlighter();
        $highlighter->setCurrentLanguage(new PhpLanguage());

        $injection = new CustomClassInjection();

        $output = $injection->parse($content, $highlighter);

        $this->assertSame(
            trim(<<<TXT
<span class="hl-a"><span class="hl-keyword">public</span> <span class="hl-keyword">class</span> <span class="hl-type">Foo</span> {}</span>
<span class="hl-b"><span class="hl-keyword">public</span> <span class="hl-keyword">class</span> <span class="hl-type">Bar</span> {}</span>
TXT),
            trim($output),
        );
    }
}
