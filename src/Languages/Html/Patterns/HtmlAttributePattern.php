<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Html\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '<x-hello attr="">', output: 'attr')]
#[PatternTest(input: '<a href="">', output: 'href')]
#[PatternTest(input: '<a data-type="">', output: 'data-type')]
#[PatternTest(input: '<x-post :foreach="$this->posts as $post">', output: ':foreach')]
#[PatternTest(input: '<xsl xmlns:xsl="http">', output: 'xmlns:xsl')]
#[PatternTest(input: "<item attr='value'>", output: 'attr')]
#[PatternTest(input: "<item simple=value>", output: 'simple')]
#[PatternTest(input: "<item with-hyphen=simple-with-hyphen>", output: 'with-hyphen')]
#[PatternTest(input: "<div class=''><span style=''></span></div>", output: ['class', 'style'])]
#[PatternTest(input: '<item
    id =
    "multiline-attr">', output: 'id')]
#[PatternTest(input: '<item
    type
    =
    "multiline-attr">', output: 'type')]
#[PatternTest(input: '<item
    a
    ="multiline-attr">', output: 'a')]
#[PatternTest(input: '<p></p>', output: null)]
# Not yet implemented
# #[PatternTest(input: "<script defer>", output: 'defer')]
final readonly class HtmlAttributePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(?<match>[\w\-:]+)\s*=\s*(?:["\']|[\w-]+)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::PROPERTY;
    }
}
