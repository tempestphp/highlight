<?php

declare(strict_types=1);

namespace Tempest\Highlight;

use Generator;
use ReflectionClass;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Base\Injections\GutterInjection;
use Tempest\Highlight\Languages\Blade\BladeLanguage;
use Tempest\Highlight\Languages\Css\CssLanguage;
use Tempest\Highlight\Languages\DocComment\DocCommentLanguage;
use Tempest\Highlight\Languages\Gdscript\GdscriptLanguage;
use Tempest\Highlight\Languages\Html\HtmlLanguage;
use Tempest\Highlight\Languages\JavaScript\JavaScriptLanguage;
use Tempest\Highlight\Languages\Json\JsonLanguage;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Languages\Sql\SqlLanguage;
use Tempest\Highlight\Languages\Twig\TwigLanguage;
use Tempest\Highlight\Languages\Xml\XmlLanguage;
use Tempest\Highlight\Languages\Yaml\YamlLanguage;
use Tempest\Highlight\Themes\CssTheme;
use Tempest\Highlight\Tokens\GroupTokens;
use Tempest\Highlight\Tokens\ParseTokens;
use Tempest\Highlight\Tokens\RenderTokens;

final class Highlighter
{
    private array $languages = [];
    private ?GutterInjection $gutterInjection = null;
    private ?Language $currentLanguage = null;
    private bool $isNested = false;

    public function __construct(
        private readonly Theme $theme = new CssTheme(),
    )
    {
        $this
            ->setLanguage('blade', new BladeLanguage())
            ->setLanguage('css', new CssLanguage())
            ->setLanguage('doc', new DocCommentLanguage())
            ->setLanguage('gdscript', new GdscriptLanguage())
            ->setLanguage('html', new HtmlLanguage())
            ->setLanguage('js', new JavaScriptLanguage())
            ->setLanguage('json', new JsonLanguage())
            ->setLanguage('php', new PhpLanguage())
            ->setLanguage('sql', new SqlLanguage())
            ->setLanguage('xml', new XmlLanguage())
            ->setLanguage('yaml', new YamlLanguage())
            ->setLanguage('yml', new YamlLanguage())
            ->setLanguage('twig', new TwigLanguage());
    }

    public function withGutter(int $startAt = 1): self
    {
        $this->gutterInjection = new GutterInjection($startAt);

        return $this;
    }

    public function getGutterInjection(): ?GutterInjection
    {
        return $this->gutterInjection;
    }

    public function setLanguage(string $name, Language $language): self
    {
        $this->languages[$name] = $language;

        return $this;
    }

    public function parse(string $content, string|Language $language): string
    {
        if (is_string($language)) {
            $language = $this->languages[$language] ?? new BaseLanguage();
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

    public function nested(): self
    {
        $clone = clone $this;

        $clone->isNested = true;

        return $clone;
    }

    private function parseContent(string $content, Language $language): string
    {
        $tokens = [];

        // Before Injections
        foreach ($this->getBeforeInjections($language) as $injection) {
            $parsedInjection = $this->parseInjection($content, $injection);
            $content = $parsedInjection->content;
            $tokens = [...$tokens, ...$parsedInjection->tokens];
        }

        // Patterns
        $tokens = [...$tokens, ...(new ParseTokens())($content, $language)];
        $groupedTokens = (new GroupTokens())($tokens);
        $content = (new RenderTokens($this->theme))($content, $groupedTokens);

        // After Injections
        foreach ($this->getAfterInjections($language) as $injection) {
            $parsedInjection = $this->parseInjection($content, $injection);
            $content = $parsedInjection->content;
        }

        // Determine proper escaping
        return match (true) {
            $this->isNested => $content,
            $this->theme instanceof TerminalTheme => Escape::terminal($content),
            default => Escape::html($content),
        };
    }

    /**
     * @param \Tempest\Highlight\Language $language
     * @return \Tempest\Highlight\Injection[]
     */
    private function getBeforeInjections(Language $language): Generator
    {
        foreach ($language->getInjections() as $injection) {
            $after = (new ReflectionClass($injection))->getAttributes(After::class)[0] ?? null;

            if ($after) {
                continue;
            }

            // Only injections without the `After` attribute are allowed
            yield $injection;
        }
    }

    /**
     * @param \Tempest\Highlight\Language $language
     * @return \Tempest\Highlight\Injection[]
     */
    private function getAfterInjections(Language $language): Generator
    {
        if ($this->isNested) {
            // After injections are only parsed at the very end
            return;
        }

        foreach ($language->getInjections() as $injection) {
            $after = (new ReflectionClass($injection))->getAttributes(After::class)[0] ?? null;

            if (! $after) {
                continue;
            }

            yield $injection;
        }

        // The gutter is always the latest injection
        if ($this->gutterInjection) {
            yield $this->gutterInjection;
        }
    }

    private function parseInjection(string $content, Injection $injection): ParsedInjection
    {
        $parsedInjection = $injection->parse(
            $content,
            $this->nested(),
        );

        // Injections are allowed to return one of two things:
        //      1. A string of content, which will be used to replace the existing content
        //      2. a `ParsedInjection` object, which contains both the new content AND a list of tokens to be parsed
        //
        // One benefit of returning ParsedInjections is that the list of returned tokens will be added
        // to all other tokens detected by patterns, and thus follow all token rules.
        // They are grouped and checked on whether tokens can be contained by other tokens.
        // This offers more flexibility from the injection's point of view, and in same cases lead to more accurate highlighting.
        //
        // The other benefit is that injections returning ParsedInjection objects don't need to worry about Escape::injection anymore.
        // This escape only exists to prevent outside patterns from matching already highlighted content that's injected.
        // If an injection doesn't highlight content anymore, then there also isn't any danger for these kinds of collisions.
        // And so, Escape::injection becomes obsolete.
        //
        // TODO: a future version might only allow ParsedTokens and no more standalone strings, but for now we'll keep it as is.
        if (is_string($parsedInjection)) {
            return new ParsedInjection($parsedInjection);
        }

        return $parsedInjection;
    }
}
