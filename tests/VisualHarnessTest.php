<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class VisualHarnessTest extends TestCase
{
    #[Test]
    public function it_renders_a_deterministic_local_dark_capture(): void
    {
        $query = ['target' => 'rust.md', 'capture' => '1'];
        $firstRender = $this->renderHarness($query);
        $secondRender = $this->renderHarness($query);

        $this->assertSame($firstRender, $secondRender);
        $this->assertStringContainsString('<h1 class="capture-header">rust.md</h1>', $firstRender);
        $this->assertStringContainsString('color-scheme: dark', $firstRender);
        $this->assertStringContainsString('background-color: #0c0c0c', $firstRender);
        $this->assertStringContainsString('data-screenshot-target="highlight-preview"', $firstRender);
        $this->assertStringContainsString('width: 1024px', $firstRender);
        $this->assertStringContainsString('id="visual-harness-probe"', $firstRender);
        $this->assertDoesNotMatchRegularExpression(
            '/<(?:iframe|img|link|script|source)\b[^>]+(?:href|src)=["\']https?:/i',
            $firstRender,
        );
        $this->assertDoesNotMatchRegularExpression('/(?:@import|url\()[^;}]*(?:https?:)?\/\//i', $firstRender);
    }

    #[Test]
    public function it_has_a_rust_capture_fixture(): void
    {
        $fixture = __DIR__ . '/targets/rust.md';

        $this->assertFileExists($fixture);
        $this->assertNotSame('', trim((string) file_get_contents($fixture)));
    }

    /**
     * @param array<string, string> $query
     */
    private function renderHarness(array $query): string
    {
        $_GET = $query;

        ob_start();
        require __DIR__ . '/index.php';

        return (string) ob_get_clean();
    }
}
