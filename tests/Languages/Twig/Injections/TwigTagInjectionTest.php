<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Twig\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Twig\Injections\TwigTagInjection;
use Tempest\Highlight\Tests\TestsInjections;

class TwigTagInjectionTest extends TestCase
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
{% <span class="hl-keyword">extends</span> &quot;<span class="hl-value">admin/empty_base.html.twig</span>&quot; %}

{% <span class="hl-keyword">block</span> javascripts %}
    {{ parent() }}
    
    &lt;script&gt;
        const mainSearchUrl = &quot;&quot;;
        const customerUrl = &quot;&quot;;
    &lt;/script&gt;
{% <span class="hl-keyword">endblock</span> %}
        ';

        $this->assertMatches(
            injection: new TwigTagInjection(),
            content: $content,
            expectedContent: $expected,
        );
    }
}
