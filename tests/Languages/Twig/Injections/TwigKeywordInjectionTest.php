<?php

declare(strict_types=1);

namespace Languages\Twig\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Injections\PhpInjection;
use Tempest\Highlight\Languages\Twig\Injections\TwigKeywordInjection;
use Tempest\Highlight\Tests\TestsInjections;

class TwigKeywordInjectionTest extends TestCase
{
    use TestsInjections;

    #[Test]
    public function test_injection(): void
    {
        $content = '
{% extends "admin/empty_base.html.twig" %}

{% block javascripts %}
	{{ parent() }}
<script>
	const mainSearchUrl = "";
	const customerUrl = "";
</script>
{% endblock %}
        ';

        $expected = '
<span class="hl-type">{%</span> <span class="hl-keyword">extends</span> &quot;<span class="hl-value">admin/empty_base.html.twig</span>&quot; <span class="hl-type">%}</span>

<span class="hl-type">{%</span> <span class="hl-keyword">block</span> javascripts <span class="hl-type">%}</span>
	{{ parent() }}
&lt;script&gt;
	const mainSearchUrl = &quot;&quot;;
	const customerUrl = &quot;&quot;;
&lt;/script&gt;
<span class="hl-type">{%</span> <span class="hl-keyword">endblock</span> <span class="hl-type">%}</span>
        ';

        $this->assertMatches(
            injection: new TwigKeywordInjection(),
            content: $content,
            expected: $expected,
        );
    }
}
