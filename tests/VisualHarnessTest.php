<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class VisualHarnessTest extends TestCase
{
    #[Test]
    public function it_uses_a_local_dark_theme_and_a_stable_capture_area(): void
    {
        $source = (string) file_get_contents(__DIR__ . '/index.php');

        $this->assertStringContainsString('highlight-dark-lite.css', $source);
        $this->assertStringContainsString('color-scheme: dark', $source);
        $this->assertStringContainsString('data-screenshot-target="highlight-preview"', $source);
        $this->assertStringContainsString('width: 1024px', $source);
        $this->assertStringNotContainsString('<link rel="stylesheet" href=', $source);
    }

    #[Test]
    public function it_has_a_rust_capture_fixture(): void
    {
        $fixture = __DIR__ . '/targets/rust.md';

        $this->assertFileExists($fixture);
        $this->assertNotSame('', trim((string) file_get_contents($fixture)));
    }
}
