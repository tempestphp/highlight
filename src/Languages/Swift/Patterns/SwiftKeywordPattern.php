<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Swift\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'guard let user else { return }', output: ['guard', 'let', 'else', 'return'])]
#[PatternTest(input: 'items.default', output: null)]
final readonly class SwiftKeywordPattern implements Pattern
{
    use IsPattern;

    /**
     * Contextual keywords that are just as often names (`open`, `optional`, `dynamic`…) are left out.
     */
    public function __construct(private array $keywords = [
        'actor', 'any', 'as', 'associatedtype', 'async', 'await', 'break', 'case', 'catch',
        'class', 'continue', 'convenience', 'default', 'defer', 'deinit', 'didSet', 'do', 'else',
        'enum', 'extension', 'fallthrough', 'fileprivate', 'final', 'for', 'func', 'get', 'guard',
        'if', 'import', 'in', 'init', 'inout', 'internal', 'is', 'lazy', 'let', 'mutating',
        'nonisolated', 'operator', 'override', 'private', 'protocol', 'public', 'repeat',
        'required', 'rethrows', 'return', 'self', 'Self', 'set', 'some', 'static', 'struct',
        'subscript', 'super', 'switch', 'throw', 'throws', 'try', 'typealias', 'unowned', 'var',
        'weak', 'where', 'while', 'willSet',
    ])
    {
    }

    public function getPattern(): string
    {
        $keywords = implode('|', $this->keywords);

        return "\b(?<!\.)(?<match>(?:{$keywords}))\b";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
