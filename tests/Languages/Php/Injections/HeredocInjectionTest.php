<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php\Injections;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Php\Injections\PhpHeredocInjection;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Tests\TestsInjections;

class HeredocInjectionTest extends TestCase
{
    use TestsInjections;

    #[Test]
    public function test_injection(): void
    {
        $content = '
$var = <<<HTML
<style>
    body {
        background-color: black;
    }
</style>
HTML;
        ';

        $expected = '
$var = &lt;&lt;&lt;<span class="hl-property">HTML</span>
&lt;<span class="hl-keyword">style</span>&gt;<span class="hl-keyword">
    body </span>{
        <span class="hl-property">background-color</span>: black;
    }
&lt;/<span class="hl-keyword">style</span>&gt;
<span class="hl-property">HTML</span>;
        ';

        $this->assertMatches(
            injection: new PhpHeredocInjection(),
            content: $content,
            expectedContent: $expected,
            currentLanguage: new PhpLanguage(),
        );
    }

    #[Test]
    public function sql_injection(): void
    {

        $content = '
$books = map(new Query(<<<SQL
    SELECT * 
    FROM Book
    LEFT JOIN …
    HAVING … 
SQL))->collection()->to(Book::class);
        ';

        $expected = '
$books = map(new Query(&lt;&lt;&lt;<span class="hl-property">SQL</span>
    <span class="hl-keyword">SELECT</span> * 
    <span class="hl-keyword">FROM</span> <span class="hl-type">Book</span>
    <span class="hl-keyword">LEFT JOIN</span> …
    <span class="hl-keyword">HAVING</span> … 
SQL))-&gt;collection()-&gt;to(Book::class);
        ';

        $this->assertMatches(
            injection: new PhpHeredocInjection(),
            content: $content,
            expectedContent: $expected,
            currentLanguage: new PhpLanguage(),
        );
    }
}
