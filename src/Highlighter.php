<?php

declare(strict_types=1);

namespace Tempest\Highlight;

use ReflectionClass;
use Tempest\Highlight\Languages\Base\Injections\GutterInjection;
use Tempest\Highlight\Languages\Blade\BladeLanguage;
use Tempest\Highlight\Languages\Css\CssLanguage;
use Tempest\Highlight\Languages\Diff\DiffLanguage;
use Tempest\Highlight\Languages\DocComment\DocCommentLanguage;
use Tempest\Highlight\Languages\Dockerfile\DockerfileLanguage;
use Tempest\Highlight\Languages\DotEnv\DotEnvLanguage;
use Tempest\Highlight\Languages\Ellison\EllisonLanguage;
use Tempest\Highlight\Languages\Gdscript\GdscriptLanguage;
use Tempest\Highlight\Languages\Html\HtmlLanguage;
use Tempest\Highlight\Languages\Ini\IniLanguage;
use Tempest\Highlight\Languages\JavaScript\JavaScriptLanguage;
use Tempest\Highlight\Languages\Json\JsonLanguage;
use Tempest\Highlight\Languages\Php\PhpLanguage;
use Tempest\Highlight\Languages\Python\PythonLanguage;
use Tempest\Highlight\Languages\Sql\SqlLanguage;
use Tempest\Highlight\Languages\Text\TextLanguage;
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
    private readonly ParseTokens $parseTokens;
    private readonly GroupTokens $groupTokens;
    private readonly RenderTokens $renderTokens;
    private readonly TextLanguage $fallbackLanguage;
    private array $patterns = [];
    private array $afterInjections = [];
    /** @var array<int, Injection[]> */
    private array $beforeInjectionsCache = [];
    /** @var array<int, Injection[]> */
    private array $afterInjectionsCache = [];
    private ?self $nestedHighlighter = null;

    public function __construct(private readonly Theme $theme = new CssTheme())
    {
        $this->addLanguage(new BladeLanguage())
            ->addLanguage(new CssLanguage())
            ->addLanguage(new DiffLanguage())
            ->addLanguage(new DocCommentLanguage())
            ->addLanguage(new DockerfileLanguage())
            ->addLanguage(new EllisonLanguage())
            ->addLanguage(new GdscriptLanguage())
            ->addLanguage(new HtmlLanguage())
            ->addLanguage(new JavaScriptLanguage())
            ->addLanguage(new JsonLanguage())
            ->addLanguage(new PhpLanguage())
            ->addLanguage(new PythonLanguage())
            ->addLanguage(new SqlLanguage())
            ->addLanguage(new XmlLanguage())
            ->addLanguage(new YamlLanguage())
            ->addLanguage(new DotEnvLanguage())
            ->addLanguage(new IniLanguage())
            ->addLanguage(new TwigLanguage());

        $this->fallbackLanguage = new TextLanguage();
        $this->parseTokens = new ParseTokens();
        $this->groupTokens = new GroupTokens();
        $this->renderTokens = new RenderTokens($this->theme);
    }

    public function withGutter(int $startAt = 1): self
    {
        $clone = clone $this;

        $clone->gutterInjection = new GutterInjection($startAt);
        $clone->nestedHighlighter = null;

        return $clone;
    }

    public function getGutterInjection(): ?GutterInjection
    {
        return $this->gutterInjection;
    }

    public function addLanguage(Language $language): self
    {
        $this->languages[$language->getName()] = $language;

        foreach ($language->getAliases() as $alias) {
            $this->languages[$alias] = $language;
        }

        $this->nestedHighlighter = null;

        return $this;
    }

    public function parse(string $content, string|Language $language): string
    {
        if (is_string($language)) {
            $language = $this->languages[$language] ?? $this->fallbackLanguage;
        }

        $this->currentLanguage = $language;

        $content = $this->normalizeNewline($content);

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

    public function getSupportedLanguageNames(): array
    {
        return array_keys($this->languages);
    }

    public function setCurrentLanguage(Language $language): void
    {
        $this->currentLanguage = $language;
    }

    public function nested(): self
    {
        $clone = clone $this;

        $clone->isNested = true;
        $clone->nestedHighlighter = null;

        return $clone;
    }

    private function getNestedHighlighter(): self
    {
        if ($this->nestedHighlighter instanceof Highlighter) {
            return $this->nestedHighlighter;
        }

        $this->nestedHighlighter = $this->nested();

        return $this->nestedHighlighter;
    }

    private function parseContent(string $content, Language $language): string
    {
        $tokens = [];
        $nestedHighlighter = $this->getNestedHighlighter();

        // Before Injections
        foreach ($this->getBeforeInjections($language) as $injection) {
            $parsedInjection = $injection->parse($content, $nestedHighlighter);
            $content = $parsedInjection->content;

            foreach ($parsedInjection->tokens as $token) {
                $tokens[] = $token;
            }
        }

        // Patterns
        foreach (
            $this->parseTokens->parse($content, $this->getPatterns($language)) as $token
        ) {
            $tokens[] = $token;
        }

        $groupedTokens = ($this->groupTokens)($tokens);
        $content = ($this->renderTokens)($content, $groupedTokens);

        // After Injections
        foreach ($this->getAfterInjections($language) as $injection) {
            $parsedInjection = $injection->parse($content, $nestedHighlighter);
            $content = $parsedInjection->content;
        }

        if ($this->isNested) {
            return $content;
        }

        return $this->theme->escape($content);
    }

    /**
     * @return Injection[]
     */
    private function getBeforeInjections(Language $language): array
    {
        $languageId = spl_object_id($language);

        if (isset($this->beforeInjectionsCache[$languageId])) {
            return $this->beforeInjectionsCache[$languageId];
        }

        $this->buildInjectionCaches($language);

        return $this->beforeInjectionsCache[$languageId];
    }

    /**
     * @return Injection[]
     */
    private function getAfterInjections(Language $language): array
    {
        if ($this->isNested) {
            return [];
        }

        $languageId = spl_object_id($language);

        if (! isset($this->afterInjectionsCache[$languageId])) {
            $this->buildInjectionCaches($language);
        }

        $afterInjections = $this->afterInjectionsCache[$languageId];

        if ($this->gutterInjection instanceof GutterInjection) {
            $afterInjections[] = $this->gutterInjection;
        }

        return $afterInjections;
    }

    private function buildInjectionCaches(Language $language): void
    {
        $languageId = spl_object_id($language);
        $before = [];
        $after = [];

        foreach ($language->getInjections() as $injection) {
            if ($this->isAfterInjection($injection)) {
                $after[] = $injection;
            } else {
                $before[] = $injection;
            }
        }

        $this->beforeInjectionsCache[$languageId] = $before;
        $this->afterInjectionsCache[$languageId] = $after;
    }

    private function normalizeNewline(string $subject): string
    {
        if (! str_contains($subject, "\r")) {
            return $subject;
        }

        return str_replace(["\r\n", "\r"], "\n", $subject);
    }

    private function getPatterns(Language $language): array
    {
        $languageId = spl_object_id($language);

        return $this->patterns[$languageId] ??= $language->getPatterns();
    }

    private function isAfterInjection(Injection $injection): bool
    {
        $class = $injection::class;

        return $this->afterInjections[$class] ??=
            new ReflectionClass($class)->getAttributes(After::class) !== [];
    }
}
