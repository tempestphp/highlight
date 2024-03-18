<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests;

use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\Language;

trait TestsInjections
{
    public function assertMatches(
        Injection $injection,
        string $content,
        string|array|null $expected,
        Language|null $currentLanguage = null,
    ) {
        $highlighter = (new Highlighter())->withoutEscaping();

        if ($currentLanguage) {
            $highlighter->setCurrentLanguage($currentLanguage);
        }

        $output = Escape::html($injection->parse($content, $highlighter));

        $this->assertSame(
            $expected,
            $output,
        );
    }
}
