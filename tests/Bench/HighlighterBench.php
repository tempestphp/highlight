<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Bench;

use Generator;
use PhpBench\Attributes as Bench;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Themes\CssTheme;

#[Bench\Warmup(1)]
#[Bench\RetryThreshold(5)]
#[Bench\OutputTimeUnit('microseconds')]
final class HighlighterBench
{
    private const string FIXTURES_DIR = __DIR__ . '/Fixtures';

    public const array LANGUAGES = [
        'blade' => 'blade.txt',
        'css' => 'css.txt',
        'diff' => 'diff.txt',
        'dockerfile' => 'dockerfile.txt',
        'dotenv' => 'dotenv.txt',
        'ellison' => 'ellison.txt',
        'gdscript' => 'gdscript.txt',
        'html' => 'html.txt',
        'ini' => 'ini.txt',
        'javascript' => 'javascript.txt',
        'json' => 'json.txt',
        'markdown' => 'markdown.txt',
        'php' => 'php.txt',
        'python' => 'python.txt',
        'sql' => 'sql.txt',
        'twig' => 'twig.txt',
        'xml' => 'xml.txt',
        'yaml' => 'yaml.txt',
    ];

    private Highlighter $highlighter;

    public function __construct()
    {
        $this->highlighter = new Highlighter(new CssTheme());
    }

    #[Bench\Revs(100)]
    #[Bench\Iterations(5)]
    #[Bench\ParamProviders('provideLanguages')]
    public function benchParse(array $params): void
    {
        $this->highlighter->parse($params['code'], $params['language']);
    }

    public function provideLanguages(): Generator
    {
        foreach (self::LANGUAGES as $language => $file) {
            yield $language => [
                'language' => $language,
                'code' => file_get_contents(self::FIXTURES_DIR . '/' . $file),
            ];
        }
    }
}
