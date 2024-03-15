<?php

declare(strict_types=1);

namespace Tempest\Highlight;

use Tempest\Highlight\Languages\CssLanguage;
use Tempest\Highlight\Languages\HtmlLanguage;
use Tempest\Highlight\Languages\PhpLanguage;
use Tempest\Highlight\Tokens\ParseTokens;
use Tempest\Highlight\Tokens\RenderTokens;

final class Highlighter
{
    private array $languages = [];

    public function __construct()
    {
        $this
            ->setLanguage('php', new PhpLanguage())
            ->setLanguage('html', new HtmlLanguage())
            ->setLanguage('css', new CssLanguage());
    }

    public function setLanguage(string $name, Language $language): self
    {
        $this->languages[$name] = $language;

        return $this;
    }

    public function parse(string $content, string $language): string
    {
        $language = $this->languages[$language] ?? null;

        if (! $language) {
            return $content;
        }

        return $this->parseContent($content, $language);
    }

    private function parseContent(string $content, Language $language): string
    {
        // Injections
        foreach ($language->getInjections() as $injection) {
            $content = $injection->parse($content, $this);
        }

        // Patterns
        $tokens = (new ParseTokens())($content, $language);

        return (new RenderTokens())($content, $tokens);
    }
}
