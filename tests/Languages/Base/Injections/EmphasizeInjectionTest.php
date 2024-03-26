<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Base\Injections\EmphasizeInjection;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Tests\TestsInjections;

final class EmphasizeInjectionTest extends TestCase
{
    use TestsInjections;

    public function test_emphasize_injection()
    {
        $content = <<<TXT
class {_Foo

test_} extends{_ Bar _}
TXT;

        $expected = <<<TXT
<span class="hl-keyword">class</span> <span class="hl-injection"><span class="hl-em"><span class="hl-type">Foo</span>

test</span></span> extends<span class="hl-injection"><span class="hl-em"> <span class="hl-type">Bar</span> </span></span>
TXT;

        $this->assertMatches(
            injection: new EmphasizeInjection(),
            content: $content,
            expected: $expected,
            currentLanguage: new PhpLanguage(),
        );
    }
}
