<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Blade\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Blade\Injections\BladeRawEchoInjection;
use Tempest\Highlight\Tests\TestsInjections;

class BladeRawEchoInjectionTest extends TestCase
{
    use TestsInjections;

    #[Test]
    public function test_injection_raw_echo(): void
    {
        $this->assertMatches(
            injection: new BladeRawEchoInjection(),
            content: '{!! count($foo) !!}',
            expected: '{!! <span class="hl-property">count</span>($foo) !!}',
        );
    }
}
