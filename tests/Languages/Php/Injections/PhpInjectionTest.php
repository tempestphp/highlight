<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Injections\PhpInjection;
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
    <span class="hl-comment">/** @var \Tempest\View\GenericView $this */</span>
    $var = <span class="hl-keyword">new</span> <span class="hl-type">Foo</span>(); 
?&gt;

Hello, &lt;?= $this-&gt;name ?&gt;
        ';

        $this->assertMatches(
            injection: new PhpInjection(),
            content: $content,
            expected: $expected,
        );
    }
}
