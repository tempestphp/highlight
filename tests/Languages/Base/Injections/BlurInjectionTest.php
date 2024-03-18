<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Base\Injections\BlurInjection;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Tests\TestsInjections;

final class BlurInjectionTest extends TestCase
{
    use TestsInjections;

    public function test_blur_injection()
    {
        $content = <<<TXT
class {~Foo

test~} extends{~ Bar ~}
TXT;

        $expected = <<<TXT
<span class="hl-keyword">class</span> <span class="hl-blur"><span class="hl-type">Foo</span>

test</span> extends<span class="hl-blur"> <span class="hl-type">Bar</span> </span>
TXT;

        $this->assertMatches(
            injection: new BlurInjection(),
            content: $content,
            expected: $expected,
            currentLanguage: new PhpLanguage(),
        );
    }
}
