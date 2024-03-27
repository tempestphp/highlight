<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Html\Injections\PhpInHtmlInjection;
use Tempest\Highlight\Tests\TestsInjections;

class PhpInjectionTest extends TestCase
{
    use TestsInjections;

    #[Test]
    public function test_injection(): void
    {
        $content = '
<?php 
    /** @var \Tempest\View\GenericView $this */
    $var = new Foo(); 
?>

Hello, <?= $this->name ?>
        ';

        $expected = '
&lt;?php 
    <span class="hl-comment">/** <span class="hl-value">@var</span> <span class="hl-type">\Tempest\View\GenericView</span> <span class="hl-variable">$this</span> */</span>
    <span class="hl-variable">$var</span> = <span class="hl-keyword">new</span> <span class="hl-type">Foo</span>(); 
?&gt;

Hello, &lt;?= $this-&gt;name ?&gt;
        ';

        $this->assertMatches(
            injection: new PhpInHtmlInjection(),
            content: $content,
            expectedContent: $expected,
        );
    }
}
