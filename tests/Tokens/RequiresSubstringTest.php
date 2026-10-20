<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Tokens;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\After;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;
use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Language;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\RequiresSubstring;
use Tempest\Highlight\Tests\Tokens\Fixtures\RequiresBarInjection;
use Tempest\Highlight\Tests\Tokens\Fixtures\RequiresBarPattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

class RequiresSubstringTest extends TestCase
{
    #[Test]
    public function pattern_is_skipped_when_content_lacks_every_required_substring(): void
    {
        $highlighter = new Highlighter();
        $language = $this->language(patterns: [new RequiresBarPattern()]);

        $this->assertSame('foo', $highlighter->parse('foo', $language));
        $this->assertSame('foo BAR', $highlighter->parse('foo BAR', $language));
        $this->assertSame('<span class="hl-keyword">foo</span> bar', $highlighter->parse('foo bar', $language));
    }

    #[Test]
    public function any_one_of_the_required_substrings_is_enough(): void
    {
        $pattern = new #[RequiresSubstring('bar', 'baz')] class () implements Pattern {
            use IsPattern;

            public function getPattern(): string
            {
                return '(?<match>foo)';
            }

            public function getTokenType(): TokenTypeEnum
            {
                return TokenTypeEnum::KEYWORD;
            }
        };

        $highlighter = new Highlighter();
        $language = $this->language(patterns: [$pattern]);

        $this->assertSame('foo', $highlighter->parse('foo', $language));
        $this->assertSame('<span class="hl-keyword">foo</span> baz', $highlighter->parse('foo baz', $language));
    }

    #[Test]
    public function empty_attribute_means_no_requirement(): void
    {
        $pattern = new #[RequiresSubstring()] class () implements Pattern {
            use IsPattern;

            public function getPattern(): string
            {
                return '(?<match>foo)';
            }

            public function getTokenType(): TokenTypeEnum
            {
                return TokenTypeEnum::KEYWORD;
            }
        };

        $highlighter = new Highlighter();
        $language = $this->language(patterns: [$pattern]);

        $this->assertSame('<span class="hl-keyword">foo</span>', $highlighter->parse('foo', $language));
    }

    #[Test]
    public function before_injection_is_skipped_when_content_lacks_every_required_substring(): void
    {
        $highlighter = new Highlighter();
        $language = $this->language(injections: [new RequiresBarInjection()]);

        $this->assertSame('foo', $highlighter->parse('foo', $language));
        $this->assertSame('FOO bar', $highlighter->parse('foo bar', $language));
    }

    #[Test]
    public function after_injection_is_skipped_when_content_lacks_every_required_substring(): void
    {
        $injection = new #[After(), RequiresSubstring('bar')] class () implements Injection {
            use IsInjection;

            public function getPattern(): string
            {
                return '(?<match>foo)';
            }

            public function parseContent(string $content, Highlighter $highlighter): string
            {
                return strtoupper($content);
            }
        };

        $highlighter = new Highlighter();
        $language = $this->language(injections: [$injection]);

        $this->assertSame('foo', $highlighter->parse('foo', $language));
        $this->assertSame('FOO bar', $highlighter->parse('foo bar', $language));
    }

    #[Test]
    public function subclasses_do_not_inherit_the_requirement(): void
    {
        $highlighter = new Highlighter();
        $language = $this->language(
            patterns: [new class () extends RequiresBarPattern {}],
            injections: [new class () extends RequiresBarInjection {}],
        );

        $this->assertSame('FOO', $highlighter->parse('foo', $language));

        $language = $this->language(patterns: [new class () extends RequiresBarPattern {}]);

        $this->assertSame('<span class="hl-keyword">foo</span>', $highlighter->parse('foo', $language));
    }

    /**
     * @param Pattern[] $patterns
     * @param Injection[] $injections
     */
    private function language(array $patterns = [], array $injections = []): Language
    {
        return new readonly class ($patterns, $injections) implements Language {
            public function __construct(
                private array $patterns,
                private array $injections,
            ) {
            }

            public function getName(): string
            {
                return 'requires-substring-test';
            }

            public function getAliases(): array
            {
                return [];
            }

            public function getInjections(): array
            {
                return $this->injections;
            }

            public function getPatterns(): array
            {
                return $this->patterns;
            }
        };
    }
}
