<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Bash;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Bash\Patterns\BashBuiltinPattern;
use Tempest\Highlight\Languages\Bash\Patterns\BashCommentPattern;
use Tempest\Highlight\Languages\Bash\Patterns\BashFlagPattern;
use Tempest\Highlight\Languages\Bash\Patterns\BashKeywordPattern;
use Tempest\Highlight\Languages\Bash\Patterns\BashNumberPattern;
use Tempest\Highlight\Languages\Bash\Patterns\BashOperatorPattern;
use Tempest\Highlight\Languages\Bash\Patterns\BashShebangPattern;
use Tempest\Highlight\Languages\Bash\Patterns\BashVariablePattern;
use Tempest\Highlight\Languages\Php\Patterns\DoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Php\Patterns\SingleQuoteValuePattern;

class BashLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'bash';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['sh', 'shell'];
    }

    #[Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
        ];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            // COMMENTS
            new BashShebangPattern(),
            new BashCommentPattern(),

            // VALUES
            new SingleQuoteValuePattern(),
            new DoubleQuoteValuePattern(),

            // KEYWORDS
            new BashKeywordPattern(),
            new BashBuiltinPattern(),

            // VARIABLES
            new BashVariablePattern(),

            // OPERATORS
            new BashOperatorPattern(),

            // NUMBERS
            new BashNumberPattern(),

            // FLAGS
            new BashFlagPattern(),
        ];
    }
}
