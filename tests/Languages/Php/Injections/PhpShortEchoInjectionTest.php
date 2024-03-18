<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Injections\PhpShortEchoInjection;
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
Hello, &lt;?= $this-&gt;<span class="hl-property">name</span> ?&gt;
Hello, &lt;?= $this-&gt;<span class="hl-property">other</span> ?&gt;
        ';

        $this->assertMatches(
            injection: new PhpShortEchoInjection(),
            content: $content,
            expected: $expected,
        );
    }
}
