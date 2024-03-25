<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Twig\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Injections\PhpInjection;
use Tempest\Highlight\Languages\Twig\Injections\TwigPropertyInjection;
use Tempest\Highlight\Tests\TestsInjections;

class TwigPropertyInjectionTest extends TestCase
{
	use TestsInjections;

	#[Test]
	public function test_injection(): void
	{
		$content = '<b>Verzia</b> {{ appVersion }}';

		$expected = '&lt;b&gt;Verzia&lt;/b&gt; <span class="hl-type">{{</span> appVersion <span class="hl-type">}}</span>';

		$this->assertMatches(
			injection: new TwigPropertyInjection(),
			content: $content,
			expected: $expected,
		);
	}
}
