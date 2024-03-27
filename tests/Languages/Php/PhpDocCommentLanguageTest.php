<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Php;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Languages\Php\PhpDocCommentLanguage;

class PhpDocCommentLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, new PhpDocCommentLanguage()),
        );
    }

    public static function data(): array
    {
        return [
            [<<<'TXT'
/**
 * This function will do some things
 * 
 * @template T
 * @param class-string<T> $className the class' name
 * @param int $id
 * @return T|null
 * 
 * That's about all
 */
TXT,
                <<<'TXT'
/**
 * This function will do some things
 * 
 * <span class="hl-value">@template</span> <span class="hl-generic">T</span>
 * <span class="hl-value">@param</span> <span class="hl-type">class-string&lt;<span class="hl-generic">T</span>&gt;</span> <span class="hl-variable">$className</span> the class' name
 * <span class="hl-value">@param</span> <span class="hl-type">int</span> <span class="hl-variable">$id</span>
 * <span class="hl-value">@return</span> <span class="hl-type"><span class="hl-generic">T</span>|null</span>
 * 
 * That's about all
 */
TXT],
        ];
    }
}
