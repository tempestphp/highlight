<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Tokens;

use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Language;
use Tempest\Highlight\Languages\Php\Patterns\KeywordPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tests\Tokens\Fixtures\ConfigurablePattern;
use Tempest\Highlight\Tests\Tokens\Fixtures\CustomMatchPattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

class CompiledPatternsTest extends TestCase
{
    #[Test]
    public function overridden_match_is_still_called(): void
    {
        $highlighter = new Highlighter();
        $language = $this->language([new CustomMatchPattern()]);

        $this->assertSame('foo <span class="hl-keyword">b</span>ar', $highlighter->parse('foo bar', $language));
        $this->assertSame('foo <span class="hl-keyword">b</span>ar', $highlighter->parse('foo bar', $language));
    }

    #[Test]
    public function third_party_patterns_are_asked_for_their_pattern_and_type_on_every_parse(): void
    {
        $pattern = new class () implements Pattern {
            use IsPattern;

            public string $word = 'foo';

            public TokenTypeEnum $type = TokenTypeEnum::KEYWORD;

            public function getPattern(): string
            {
                return "(?<match>{$this->word})";
            }

            public function getTokenType(): TokenTypeEnum
            {
                return $this->type;
            }
        };

        $highlighter = new Highlighter();
        $language = $this->language([$pattern]);

        $this->assertSame('<span class="hl-keyword">foo</span> bar', $highlighter->parse('foo bar', $language));

        $pattern->word = 'bar';
        $pattern->type = TokenTypeEnum::TYPE;

        $this->assertSame('foo <span class="hl-type">bar</span>', $highlighter->parse('foo bar', $language));
    }

    #[Test]
    public function built_in_patterns_with_mutable_state_are_asked_again_on_every_parse(): void
    {
        $pattern = new KeywordPattern('select');
        $highlighter = new Highlighter();
        $language = $this->language([$pattern]);

        $this->assertSame('<span class="hl-keyword">select</span> SELECT;', $highlighter->parse('select SELECT;', $language));

        $pattern->caseInsensitive();

        $this->assertSame(
            '<span class="hl-keyword">select</span> <span class="hl-keyword">SELECT</span>;',
            $highlighter->parse('select SELECT;', $language),
        );
    }

    #[Test]
    public function patterns_outside_the_package_are_asked_again_on_every_parse_even_in_its_namespace(): void
    {
        $config = new ArrayObject(['word' => 'foo', 'type' => TokenTypeEnum::KEYWORD]);
        $highlighter = new Highlighter();
        $language = $this->language([new ConfigurablePattern($config)]);

        $this->assertSame('<span class="hl-keyword">foo</span> bar', $highlighter->parse('foo bar', $language));

        $config['word'] = 'bar';
        $config['type'] = TokenTypeEnum::TYPE;

        $this->assertSame('foo <span class="hl-type">bar</span>', $highlighter->parse('foo bar', $language));
    }

    /**
     * @param Pattern[] $patterns
     */
    private function language(array $patterns): Language
    {
        return new readonly class ($patterns) implements Language {
            public function __construct(
                private array $patterns,
            ) {
            }

            public function getName(): string
            {
                return 'compiled-patterns-test';
            }

            public function getAliases(): array
            {
                return [];
            }

            public function getInjections(): array
            {
                return [];
            }

            public function getPatterns(): array
            {
                return $this->patterns;
            }
        };
    }
}
