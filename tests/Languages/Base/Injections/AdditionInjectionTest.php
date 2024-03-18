<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Base\Injections\AdditionInjection;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Tests\TestsInjections;

class AdditionInjectionTest extends TestCase
{
    use TestsInjections;

    public function test_addition_injection()
    {
        $content = <<<TXT
{+ class Foo +}
TXT;

        $expected = <<<TXT
<span class="hl-addition"> <span class="hl-keyword">class</span> <span class="hl-type">Foo</span> </span>
TXT;

        $this->assertMatches(
            injection: new AdditionInjection(),
            content: $content,
            expected: $expected,
            currentLanguage: new PhpLanguage(),
        );
    }
}
