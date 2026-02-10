<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Bench;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Language;

class HighlighterBenchTest extends TestCase
{
    private const string FIXTURES_DIR = __DIR__ . '/Fixtures';

    private const array INTERNAL_LANGUAGES = [
        'doc',
    ];

    #[Test]
    public function every_supported_language_has_a_bench_fixture(): void
    {
        $highlighter = new Highlighter();

        $languages = $this->getCanonicalLanguages($highlighter);

        $benchLanguages = array_keys(HighlighterBench::LANGUAGES);

        $missing = [];

        foreach ($languages as $language) {
            $nameAndAliases = [$language->getName(), ...$language->getAliases()];

            if (array_intersect($nameAndAliases, $benchLanguages) === []) {
                $missing[] = $language->getName();
            }
        }

        $this->assertSame(
            [],
            $missing,
            sprintf(
                'The following languages are supported but have no bench entry: %s. Add them to HighlighterBench::LANGUAGES and create fixture files.',
                implode(', ', $missing),
            ),
        );
    }

    #[Test]
    public function every_bench_fixture_file_exists(): void
    {
        foreach (HighlighterBench::LANGUAGES as $language => $file) {
            $path = self::FIXTURES_DIR . '/' . $file;

            $this->assertFileExists(
                $path,
                sprintf('Fixture file for language "%s" is missing: %s', $language, $file),
            );
        }
    }

    #[Test]
    public function every_bench_fixture_file_is_not_empty(): void
    {
        foreach (HighlighterBench::LANGUAGES as $language => $file) {
            $path = self::FIXTURES_DIR . '/' . $file;

            if (! file_exists($path)) {
                continue;
            }

            $this->assertNotEmpty(
                trim(file_get_contents($path)),
                sprintf('Fixture file for language "%s" is empty: %s', $language, $file),
            );
        }
    }

    #[Test]
    public function bench_does_not_reference_unknown_languages(): void
    {
        $highlighter = new Highlighter();
        $supportedNames = $highlighter->getSupportedLanguageNames();

        foreach (array_keys(HighlighterBench::LANGUAGES) as $language) {
            $this->assertContains(
                $language,
                $supportedNames,
                sprintf('Bench references language "%s" which is not registered in the Highlighter.', $language),
            );
        }
    }

    /** @return Language[] */
    private function getCanonicalLanguages(Highlighter $highlighter): array
    {
        $allNames = $highlighter->getSupportedLanguageNames();

        $seen = [];
        $languages = [];

        foreach ($allNames as $name) {
            $highlighter->parse('', $name);
            $language = $highlighter->getCurrentLanguage();

            $id = spl_object_id($language);

            if (isset($seen[$id])) {
                continue;
            }

            $seen[$id] = true;

            if (in_array($language->getName(), self::INTERNAL_LANGUAGES, true)) {
                continue;
            }

            $languages[] = $language;
        }

        return $languages;
    }
}
