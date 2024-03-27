<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Injections\PhpHeredocInjection;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Tests\TestsInjections;

class HeredocInjectionTest extends TestCase
{
    use TestsInjections;

    #[Test]
    public function test_injection(): void
    {
        $content = '
$var = <<<HTML
<style>
    body {
        background-color: black;
    }
</style>
HTML;
        ';

        $expected = '
$var = &lt;&lt;&lt;<span class="hl-property">HTML</span>
&lt;<span class="hl-keyword">style</span>&gt;<span class="hl-keyword">
    body </span>{
        <span class="hl-property">background-color</span>: black;
    }
&lt;/<span class="hl-keyword">style</span>&gt;
<span class="hl-property">HTML</span>;
        ';

        $this->assertMatches(
            injection: new PhpHeredocInjection(),
            content: $content,
            expectedContent: $expected,
            currentLanguage: new PhpLanguage(),
        );
    }
}
