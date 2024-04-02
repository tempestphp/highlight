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
        string|array|null $expectedContent,
        Language|null $currentLanguage = null,
    ) {
        $highlighter = (new Highlighter())->nested();

        if ($currentLanguage) {
            $highlighter->setCurrentLanguage($currentLanguage);
        }

        $parsedInjection = $injection->parse($content, $highlighter);

        if (is_string($parsedInjection)) {
            $content = $parsedInjection;
        } else {
            $content = $parsedInjection->content;
        }

        $output = Escape::html($content);

        $this->assertSame(
            $expectedContent,
            $output,
        );
    }
}
