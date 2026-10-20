<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Bench;

use PhpBench\Attributes as Bench;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\CssTheme;

/**
 * Guards inputs that once blew up: unclosed markers, long string literals and very large files.
 */
#[Bench\Warmup(1)]
#[Bench\Iterations(3)]
#[Bench\OutputTimeUnit('milliseconds')]
final class EdgeCaseBench
{
    private Highlighter $highlighter;

    private string $php;

    public function __construct()
    {
        $this->highlighter = new Highlighter(new CssTheme());
        $this->php = file_get_contents(__DIR__ . '/Fixtures/php.txt');
    }

    #[Bench\Revs(3)]
    public function benchUnclosedMarkers(): void
    {
        $this->highlighter->parse(str_repeat("{-1: 'neg'}\n", 8_500), 'txt');
    }

    #[Bench\Revs(5)]
    public function benchLongStringLiteral(): void
    {
        $this->highlighter->parse("<?php\n\$s = '" . str_repeat('a', 7_000) . "';\n" . $this->php, 'php');
    }

    #[Bench\Revs(1)]
    public function benchOneMegabytePhp(): void
    {
        $this->highlighter->parse(str_repeat($this->php . "\n", 335), 'php');
    }
}
