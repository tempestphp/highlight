<?php

declare(strict_types=1);

namespace Tempest\Highlight;

use Tempest\Highlight\Languages\Blade\BladeLanguage;
use Tempest\Highlight\Languages\Css\CssLanguage;
use Tempest\Highlight\Languages\Html\HtmlLanguage;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Themes\CssTheme;
use Tempest\Highlight\Tokens\ParseTokens;
use Tempest\Highlight\Tokens\RenderTokens;

final class Highlighter
{
    private array $languages = [];
    private ?Language $currentLanguage = null;

    public function __construct(
        private Theme $theme = new CssTheme(),
    ) {
        $this
            ->setLanguage('php', new PhpLanguage())
            ->setLanguage('html', new HtmlLanguage())
            ->setLanguage('blade', new BladeLanguage())
            ->setLanguage('css', new CssLanguage());
    }

    public function setLanguage(string $name, Language $language): self
    {
        $this->languages[$name] = $language;

        return $this;
    }

    public function parse(string $content, string|Language $language): string
    {
        if (is_string($language)) {
            $language = $this->languages[$language] ?? null;
        }

        if (! $language) {
            return $content;
        }

        $this->currentLanguage = $language;

        return $this->parseContent($content, $language);
    }

    public function getCurrentLanguage(): ?Language
    {
        return $this->currentLanguage;
    }

    public function setCurrentLanguage(Language $language): void
    {
        $this->currentLanguage = $language;
    }

    private function parseContent(string $content, Language $language): string
    {
        // Injections
        foreach ($language->getInjections() as $injection) {
            $content = $injection->parse($content, clone $this);
        }

        // Patterns
        $tokens = (new ParseTokens())($content, $language);

        return (new RenderTokens($this->theme))($content, $tokens);
    }
}
