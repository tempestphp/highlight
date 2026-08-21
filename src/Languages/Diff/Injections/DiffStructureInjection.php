<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Diff\Injections;

use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\Languages\Diff\DiffParser;
use Tempest\Highlight\ParsedInjection;

final readonly class DiffStructureInjection implements Injection
{
    public function __construct(
        private DiffParser $parser = new DiffParser(),
    ) {
    }

    public function parse(string $content, Highlighter $highlighter): ParsedInjection
    {
        return new ParsedInjection($content, $this->parser->parse($content));
    }
}
