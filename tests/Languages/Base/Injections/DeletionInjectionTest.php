<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Base\Injections;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Base\Injections\DeletionInjection;
use Tempest\Highlight\Languages\Blade\BladeLanguage;
use Tempest\Highlight\Tests\TestsInjections;

class DeletionInjectionTest extends TestCase
{
    use TestsInjections;

    public function test_deletion_injection()
    {
        $content = <<<TXT
{- class Foo -}
{{-- class Foo --}}
TXT;

        $expected = <<<TXT
<span class="hl-deletion"> class Foo </span>
<span class="hl-comment">{{-- <span class="hl-keyword">class</span> <span class="hl-type">Foo</span> --}}</span>
TXT;

        $this->assertMatches(
            injection: new DeletionInjection(),
            content: $content,
            expected: $expected,
            currentLanguage: new BladeLanguage(),
        );
    }
}
