<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Sql;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\LightTerminalTheme;

class SqlLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'sql'),
        );
    }

    public static function data(): array
    {
        return [
            // Test 1
            [
                '-- single-line comment

SELECT country.country_name_eng, city.city_name, customer.customer_name
FROM country AS country
         INNER JOIN city ON city.country_id = country.id
         INNER JOIN customer ON customer.city_id = city.id;

/*
multi-line comment
*/

SELECT *;',
                '<span class="hl-comment">-- single-line comment</span>

<span class="hl-keyword">SELECT</span> <span class="hl-type">country</span>.<span class="hl-property">country_name_eng</span>, <span class="hl-type">city</span>.<span class="hl-property">city_name</span>, <span class="hl-type">customer</span>.<span class="hl-property">customer_name</span>
<span class="hl-keyword">FROM</span> <span class="hl-type">country</span> <span class="hl-keyword">AS</span> <span class="hl-type">country</span>
         <span class="hl-keyword">INNER JOIN</span> <span class="hl-type">city</span> <span class="hl-keyword">ON</span> <span class="hl-type">city</span>.<span class="hl-property">country_id</span> = <span class="hl-type">country</span>.<span class="hl-property">id</span>
         <span class="hl-keyword">INNER JOIN</span> <span class="hl-type">customer</span> <span class="hl-keyword">ON</span> <span class="hl-type">customer</span>.<span class="hl-property">city_id</span> = <span class="hl-type">city</span>.<span class="hl-property">id</span>;

<span class="hl-comment">/*
multi-line comment
*/</span>

<span class="hl-keyword">SELECT</span> *;',
            ],

            // test 2
            ['SELECT baz, country.foo, bar, COUNT(*) AS c', '<span class="hl-keyword">SELECT</span> <span class="hl-property">baz</span>, <span class="hl-type">country</span>.<span class="hl-property">foo</span>, <span class="hl-property">bar</span>, <span class="hl-property">COUNT</span>(*) <span class="hl-keyword">AS</span> <span class="hl-type">c</span>'],

            // test 3
            ["WHERE bar = 'foo'", "<span class=\"hl-keyword\">WHERE</span> bar = '<span class=\"hl-value\">foo</span>'"],

            // test 4
            ['WHERE bar = "foo"', "<span class=\"hl-keyword\">WHERE</span> bar = &quot;<span class=\"hl-value\">foo</span>&quot;"],

            // test 5
            [
                <<<SQL
                SELECT name, age, hobby FROM students_hobbies
                WHERE age BETWEEN 25 AND 30
                INTERSECT
                SELECT name, age, hobby FROM students
                WHERE age BETWEEN 20 AND 30;
                SQL,
                <<<HTML
                <span class="hl-keyword">SELECT</span> <span class="hl-property">name</span>, <span class="hl-property">age</span>, <span class="hl-property">hobby</span> <span class="hl-keyword">FROM</span> <span class="hl-type">students_hobbies</span>
                <span class="hl-keyword">WHERE</span> age <span class="hl-keyword">BETWEEN</span> 25 <span class="hl-keyword">AND</span> 30
                <span class="hl-keyword">INTERSECT</span>
                <span class="hl-keyword">SELECT</span> <span class="hl-property">name</span>, <span class="hl-property">age</span>, <span class="hl-property">hobby</span> <span class="hl-keyword">FROM</span> <span class="hl-type">students</span>
                <span class="hl-keyword">WHERE</span> age <span class="hl-keyword">BETWEEN</span> 20 <span class="hl-keyword">AND</span> 30;
                HTML
            ],
        ];
    }

    public function test_highlight_in_terminal()
    {
        $highlighter = new Highlighter(new LightTerminalTheme());

        $sql = <<<SQL
        ALTER TABLE "packages"   DROP COLUMN updated_at_orig;
        SQL;
        // Encode in base64 to avoid storing binary escapes in the source code.
        $expected = base64_decode(<<<'ESC'
        G1szNG1BTFRFUiBUQUJMRRtbMG0gIhtbMzBtcGFja2FnZXMbWzBtIiAgIBtbMzRtRFJPUCBDT0xVTU4bWzBtIHVwZGF0ZWRfYXRfb3JpZzs=
        ESC);

        $this->assertSame($expected, $highlighter->parse($sql, 'sql'));
    }
}
