<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Yaml;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

final class YamlLongLineTest extends TestCase
{
    public function test_long_comment_keeps_later_comments(): void
    {
        $highlighter = new Highlighter();

        $this->assertStringContainsString(
            '<span class="hl-comment"># x</span>',
            $highlighter->parse('# ' . str_repeat('a', 14000) . "\n# x", 'yaml'),
        );
    }
}
