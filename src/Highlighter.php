<?php

declare(strict_types=1);

namespace Tempest\Highlight;

use Tempest\Highlight\Languages\Blade\BladeLanguage;
use Tempest\Highlight\Languages\Css\CssLanguage;
use Tempest\Highlight\Languages\Html\HtmlLanguage;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Languages\Sql\SqlLanguage;
use Tempest\Highlight\Languages\Yaml\YamlLanguage;
use Tempest\Highlight\Themes\CssTheme;
use Tempest\Highlight\Tokens\GroupTokens;
use Tempest\Highlight\Tokens\ParseTokens;
use Tempest\Highlight\Tokens\RenderTokens;

final class Highlighter
{
    private array $languages = [];
    private ?Language $currentLanguage = null;
    private bool $shouldEscape = true;

    public function __construct(
        private readonly Theme $theme = new CssTheme(),
    ) {
        $this
            ->setLanguage('php', new PhpLanguage())
            ->setLanguage('html', new HtmlLanguage())
            ->setLanguage('sql', new SqlLanguage())
            ->setLanguage('blade', new BladeLanguage())
            ->setLanguage('yaml', new YamlLanguage())
            ->setLanguage('yml', new YamlLanguage())
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
            return $this->shouldEscape ?
                Escape::html($content)
                : $content;
        }

        $this->currentLanguage = $language;

        return $this->parseContent($content, $language);
    }

    public function getTheme(): Theme
    {
        return $this->theme;
    }

    public function getCurrentLanguage(): ?Language
    {
        return $this->currentLanguage;
    }

    public function setCurrentLanguage(Language $language): void
    {
        $this->currentLanguage = $language;
    }

    public function withoutEscaping(): self
    {
        $clone = clone $this;

        $clone->shouldEscape = false;

        return $clone;
    }

    private function parseContent(string $content, Language $language): string
    {
        // Injections
        foreach ($language->getInjections() as $injection) {
            $content = $injection->parse($content, $this->withoutEscaping());
        }

        // Patterns
        $tokens = (new ParseTokens())($content, $language);

        $groupedTokens = (new GroupTokens())($tokens);

        $output = (new RenderTokens($this->theme))($content, $groupedTokens);

        return $this->shouldEscape
            ? Escape::html($output)
            : $output;
    }
}
