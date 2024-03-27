<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Html\Injections\PhpShortEchoInHtmlInjection;
use Tempest\Highlight\Tests\TestsInjections;

class PhpShortEchoInjectionTest extends TestCase
{
    use TestsInjections;

    #[Test]
    public function test_injection(): void
    {
        $content = '
Hello, <?= $this->name ?>
Hello, <?= $this->other ?>
        ';

        $expected = '
Hello, &lt;?= <span class="hl-variable">$this</span>-&gt;<span class="hl-property">name</span> ?&gt;
Hello, &lt;?= <span class="hl-variable">$this</span>-&gt;<span class="hl-property">other</span> ?&gt;
        ';

        $this->assertMatches(
            injection: new PhpShortEchoInHtmlInjection(),
            content: $content,
            expectedContent: $expected,
        );
    }
}
