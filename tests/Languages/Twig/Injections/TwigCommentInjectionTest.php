<?php

declare(strict_types=1);

namespace Languages\Twig\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Injections\PhpInjection;
use Tempest\Highlight\Languages\Twig\Injections\TwigCommentInjection;
use Tempest\Highlight\Tests\TestsInjections;

class TwigCommentInjectionTest extends TestCase
{
    use TestsInjections;

    #[Test]
    public function test_injection(): void
    {
        $content = '
<a class="nav-link">
{#<span class="material-symbols-outlined">menu</span>#}
</a>
       	';

        $expected = '
&lt;a class=&quot;nav-link&quot;&gt;
<span class="hl-comment">{#&lt;span class=&quot;material-symbols-outlined&quot;&gt;menu&lt;/span&gt;#}</span>
&lt;/a&gt;
       	';

        $this->assertMatches(
            injection: new TwigCommentInjection(),
            content: $content,
            expected: $expected,
        );
    }
}
