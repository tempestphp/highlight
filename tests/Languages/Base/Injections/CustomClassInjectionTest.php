<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Base\Injections\CustomClassInjection;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Tests\TestsInjections;

class CustomClassInjectionTest extends TestCase
{
    use TestsInjections;

    public function test_custom_class_injection()
    {
        $content = <<<TXT
{:hl-a:public class Foo {}:}
{:hl-b:public class Bar {}:}
TXT;

        $expected = <<<TXT
<span class="hl-a"><span class="hl-keyword">public</span> <span class="hl-keyword">class</span> <span class="hl-type">Foo</span> {}</span>
<span class="hl-b"><span class="hl-keyword">public</span> <span class="hl-keyword">class</span> <span class="hl-type">Bar</span> {}</span>
TXT;

        $this->assertMatches(
            injection: new CustomClassInjection(),
            content: $content,
            expected: $expected,
            currentLanguage: new PhpLanguage(),
        );
    }
}
