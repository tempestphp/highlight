<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Php\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: 'catch (Foo) {}', output: 'Foo')]
#[PatternTest(input: 'catch(Foo) {}', output: 'Foo')]
#[PatternTest(input: 'catch (Foo $foo) {}', output: 'Foo')]
#[PatternTest(input: 'catch (Foo|Bar) {}', output: 'Foo|Bar')]
#[PatternTest(input: 'catch (Foo|Bar $bar) {}', output: 'Foo|Bar')]
final readonly class CatchTypePattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return 'catch\s*\((?<match>[\w\||]+)(\)|\s)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::TYPE;
    }
}
