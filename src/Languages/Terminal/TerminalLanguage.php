<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Terminal;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Bash\Patterns\BashFlagPattern;
use Tempest\Highlight\Languages\Bash\Patterns\BashNumberPattern;
use Tempest\Highlight\Languages\Bash\Patterns\BashOperatorPattern;
use Tempest\Highlight\Languages\Bash\Patterns\BashVariablePattern;
use Tempest\Highlight\Languages\Php\Patterns\DoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Php\Patterns\SingleQuoteValuePattern;
use Tempest\Highlight\Languages\Terminal\Patterns\TerminalCommandNamePattern;
use Tempest\Highlight\Languages\Terminal\Patterns\TerminalFilePathPattern;
use Tempest\Highlight\Languages\Terminal\Patterns\TerminalPromptPattern;
use Tempest\Highlight\Languages\Terminal\Patterns\TerminalScopedPackagePattern;
use Tempest\Highlight\Languages\Terminal\Patterns\TerminalUrlPattern;

class TerminalLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'terminal';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['console', 'term'];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            // PROMPT
            new TerminalPromptPattern(),

            // VALUES
            new TerminalUrlPattern(),
            new SingleQuoteValuePattern(),
            new DoubleQuoteValuePattern(),

            // COMMAND NAME
            new TerminalCommandNamePattern(),

            // SCOPED PACKAGES
            new TerminalScopedPackagePattern(),

            // FILE PATHS
            new TerminalFilePathPattern(),

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
