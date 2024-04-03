<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Themes;

use Exception;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Themes\InlineTheme;

class InlineThemeTest extends TestCase
{
    public function test_invalid_css_path(): void
    {
        $this->expectException(Exception::class);

        new InlineTheme('invalid/path.css');
    }
}
