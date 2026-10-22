# Language implementation guide

These instructions apply throughout this repository. Follow them when adding a language or changing language support. Keep changes limited to the requested syntax and its tests. Do not refactor other languages as part of an addition.

## Start with existing implementations

Read `src/Language.php`, `src/Languages/Base/BaseLanguage.php`, `src/Pattern.php`, `src/IsPattern.php`, `src/PatternTest.php`, and `tests/TestsPatterns.php` before implementing a language.

Choose the closest existing language as a reference:

- `src/Languages/Swift/SwiftLanguage.php` and its patterns show a standalone language split into syntax features.
- `src/Languages/Python/PythonLanguage.php` shows aliases and reuse of existing patterns.
- `src/Languages/Jsx/JsxLanguage.php` and `src/Languages/Tsx/TsxLanguage.php` show extensions of existing languages. Their tests cover registration, inherited aliases, escaping, and incomplete input.
- `src/Languages/Html/HtmlLanguage.php` shows embedded languages handled through injections.
- `src/Languages/Ruby/` shows a shared lexer for syntax that needs context beyond a regular expression.

Use these files as structural references. Existing gaps in their syntax coverage are not requirements to reproduce.

## Required files and registration

Use the existing directory and namespace layout:

```text
src/Languages/<Language>/<Language>Language.php
src/Languages/<Language>/Patterns/<Feature>Pattern.php
src/Languages/<Language>/Injections/<Feature>Injection.php   # when needed
tests/Languages/<Language>/<Language>LanguageTest.php
tests/Languages/<Language>/Patterns/<Feature>PatternTest.php # when needed
tests/Languages/<Language>/Injections/<Feature>InjectionTest.php # when needed
tests/Bench/Fixtures/<language>.txt
```

- Match directory, class, and namespace casing. Production namespaces start with `Tempest\Highlight\Languages`; test namespaces start with `Tempest\Highlight\Tests\Languages`.
- Extend `BaseLanguage` for a standalone language. Extend a related language only when the new language shares its syntax.
- Return a stable lowercase identifier from `getName()`. Add conventional identifiers or extensions through `getAliases()`.
- Explicitly override inherited aliases for a derived language. Return `[]` when none apply. A new language must not overwrite the parent language's registered names or aliases.
- Import and register the language with `addLanguage(new <Language>Language())` in `src/Highlighter.php`. Merely creating the class does not make string-based selection work.
- Add a non-empty, representative benchmark fixture and an entry in `tests/Bench/HighlighterBench.php::LANGUAGES`. `HighlighterBenchTest` checks coverage, file existence, contents, and registered names.

## The language class assembles syntax features

Keep the language file focused on its name, aliases, patterns, and injections. Put syntax matching in separate pattern classes, following the existing `<Feature>Pattern` naming convention. Do not put a whole grammar or a large collection of inline regexes in the language file.

Override `getPatterns()` and preserve the base patterns with `...parent::getPatterns()`. Group language-specific instances by their purpose, such as keywords, types, attributes, properties, comments, numbers, literals, operators, values, and variables. Only include categories supported by the language. For a derived language, inspect the inherited patterns before adding overlapping ones.

Override `getInjections()` only when adding or deliberately adjusting injections. Preserve `...parent::getInjections()` so the built-in highlighting annotations continue to work. Do not add an override that only returns the parent list.

Use `#[Override]` on overridden methods. Match the repository's PHP style, including strict types, typed signatures, sorted imports, short arrays, and trailing commas in multiline lists. Use `final readonly` for stateless pattern classes where appropriate, as in Swift and JSX.

Before coding, identify the syntax the implementation will support. Cover the language's relevant keywords, declarations, comments, strings, numeric and other literals, operators, and identifiers. Include attributes, annotations, decorators, interpolation, or embedded languages where they apply. State any unsupported forms in the change description instead of claiming complete support.

## Pattern contract

- Implement `Pattern`. Use `IsPattern` for ordinary regex matching, with `getPattern(): string` and `getTokenType(): TokenTypeEnum`.
- Capture exactly the text to highlight in a named `(?<match>...)` group. Context needed to recognize the token belongs outside that group. An unnamed capture alone will not produce a token.
- `IsPattern` returns `preg_match_all` results with `PREG_OFFSET_CAPTURE`. A custom `match()` must preserve that result shape, including an empty `match` array for no matches and byte offsets into the original input.
- Use existing `TokenTypeEnum` cases. Read `TokenTypeEnum::canContain()` and `src/Tokens/GroupTokens.php` before relying on overlapping or nested tokens. Pattern order alone does not define which token wins.
- Reuse another language's pattern only when its syntax and token meaning fit. Test the reused behavior in the new language's integration tests.
- Keep regexes bounded to the intended syntax. Check identifier boundaries, escaping, multiline behavior, and incomplete input. Avoid unbounded backtracking on long or unterminated strings, comments, tags, and attributes.
- Use a small shared scanner when syntax needs state, as Ruby does. Preserve source length and offsets when masking text. Do not change the core parser just to accommodate one language without a demonstrated need and regression tests.

## Required tests on pattern classes

Add repeatable `#[PatternTest(input: ..., output: ...)]` attributes directly to every new pattern that can be constructed without arguments. Add or update those cases whenever changing an existing pattern. These are executable tests, not documentation examples.

```php
<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Example\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'let item', output: 'let')]
#[PatternTest(input: 'let first; let second', output: ['let', 'let'])]
#[PatternTest(input: 'letter', output: null)]
final readonly class ExampleKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '\b(?<match>let)\b';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
```

For each pattern, cover a normal match, multiple matches where applicable, a near miss with `output: null`, and relevant boundary or whitespace cases. Add cases for multiline and escaped forms when the syntax supports them. Use `string` for one expected capture, `array` for captures in source order, and `null` for no captures.

`tests/PatternsTest.php` discovers attributes on classes directly inside `src/Languages/*/Patterns/*.php` and instantiates them without arguments. Keep new patterns at that depth. Constructor-dependent patterns need dedicated PHPUnit tests using `TestsPatterns`, as in `tests/Languages/Dockerfile/Patterns/KeywordPatternTest.php`.

`TestsPatterns::assertMatches()` checks expected capture values but does not reject extra matches for a non-null expectation. If exact counts, offsets, token types, or custom matching behavior matter, add a dedicated test that asserts those properties. Attributes also do not prove that a pattern is registered or renders correctly.

## Attribute, annotation, and decorator coverage

Distinguish PHP `#[PatternTest]` test attributes from the target language's attribute syntax. Both need coverage when introducing an attribute-related pattern.

For syntax the new language supports, include direct pattern cases and rendered language tests for:

- A simple attribute, annotation, or decorator and its qualified or namespaced form.
- Arguments, named arguments, multiple or stacked attributes, and multiline layout.
- Similar ordinary code that must not match, including identifiers containing the same text.
- Attribute-like text inside strings and comments. Assert the final output keeps the intended string or comment token without unwanted nested highlighting.
- Missing closing delimiters and long incomplete input. Assert `PREG_NO_ERROR` after matching where regex complexity is a risk, following `JsxLanguageTest`.

For markup attributes, also cover quoted values, expression values, whitespace around `=`, multiple attributes, and language-supported boolean, spread, prefixed, or hyphenated names. Include an assignment outside a tag as a negative case when it could be confused with an attribute.

Choose token types from existing semantics rather than the class name. `SwiftAttributePattern` uses `ATTRIBUTE`, `HtmlAttributePattern` and `JsxAttributePattern` use `PROPERTY`, `JsxSpreadAttributePattern` uses `ATTRIBUTE`, and PHP's `AttributeTypePattern` uses `TYPE`. Verify both capture boundaries and rendered nesting.

## Required language and injection tests

Create `<Language>LanguageTest` with PHPUnit and use `#[DataProvider('provide_<name>_cases')]` with static iterable providers for multiple cases. Follow the existing `test_snake_case` method names.

- Parse through `new Highlighter()` using the registered string identifier. Assert registration, canonical name, and each alias. For derived languages, assert that the parent identifiers still select the parent language.
- Assert exact rendered output with `assertSame()`, including `hl-*` spans, escaping, whitespace, and newlines. Use literal nowdocs for source examples where PHP interpolation would alter the input.
- Include a realistic snippet combining the implemented features and focused cases for overlaps. Check that keywords or numbers inside comments and strings do not produce unintended highlighting.
- Verify that HTML-sensitive input remains escaped and that rendering preserves the source apart from the highlighter's newline normalization and reserved-marker removal. See `JsxLanguageTest` for a source round-trip assertion.
- Add a regression case for every syntax bug fixed. Do not replace expected output with the implementation's actual output without checking the intended token boundaries.

Use injections for embedded languages or transformations that need nested highlighting. Implement `Injection`, usually with `IsInjection`, and register it through `getInjections()`. Injections run before patterns unless marked `#[After]`. During nested processing, `Highlighter` skips all after-injections, including those marked `#[After]`. Do not rely on them to process embedded code. Add dedicated tests using `TestsInjections` and at least one test through the containing language. Check boundaries and surrounding text so an injection does not consume neighboring code.

An optional `tests/targets/<language>.md` example can help inspect the result through `tests/index.php`. It does not replace automated assertions.

## Validation before handing over language changes

Use PHP 8.4 or later and install development dependencies with `composer install`. Run commands from the repository root, replacing `<Language>` with the actual directory.

During development, use the focused checks relevant to the change:

```sh
composer phpunit -- tests/PatternsTest.php
composer phpunit -- tests/Languages/<Language>
composer phpunit -- tests/Bench/HighlighterBenchTest.php
composer phpunit -- tests/HighlighterTest.php
```

Run related parent or host language tests when reusing patterns, extending a language, or adding injections.

Before handing over language changes, run the full PHPUnit suite, static analysis, and style check. The full suite includes the focused tests above, so there is no need to repeat those separately at handoff:

```sh
composer phpunit
composer phpstan
vendor/bin/php-cs-fixer fix --allow-risky=yes --dry-run --diff
```

Run `composer bench` when changing matching performance or introducing complex regexes or scanners, and compare the affected language before and after.

`composer csfixer` writes formatting changes. `composer qa` also runs that formatter before static analysis and tests. Inspect the diff and avoid unrelated formatting changes. Report which checks ran, their results, and any checks that could not run. For documentation-only changes, verify paths and commands against the repository; a PHP test run is unnecessary.
