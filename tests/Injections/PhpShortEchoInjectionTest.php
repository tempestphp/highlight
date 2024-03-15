<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Php\Injections\PhpShortEchoInjection;

class PhpShortEchoInjectionTest extends TestCase
{
    #[Test]
    public function test_injection(): void
    {
        $content = htmlentities('
<?php 
    /** @var \Tempest\View\GenericView $this */
    $var = new Foo(); 
?>

Hello, <?= $this->name ?>
Hello, <?= $this->other ?>
        ');

        $highlighter = new Highlighter();
        $injection = new PhpShortEchoInjection();

        $output = $injection->parse($content, $highlighter);

        $this->assertStringContainsString(
            '<span class="hl-property">name</span>',
            $output,
        );

        $this->assertStringContainsString(
            '<span class="hl-property">other</span>',
            $output,
        );
    }
}
