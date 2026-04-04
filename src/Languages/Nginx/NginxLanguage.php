<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Nginx;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Bash\Patterns\BashCommentPattern;
use Tempest\Highlight\Languages\Bash\Patterns\BashNumberPattern;
use Tempest\Highlight\Languages\Nginx\Patterns\NginxBooleanPattern;
use Tempest\Highlight\Languages\Nginx\Patterns\NginxDirectivePattern;
use Tempest\Highlight\Languages\Nginx\Patterns\NginxOperatorPattern;
use Tempest\Highlight\Languages\Nginx\Patterns\NginxVariablePattern;
use Tempest\Highlight\Languages\Php\Patterns\DoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Php\Patterns\SingleQuoteValuePattern;

class NginxLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'nginx';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['nginxconf'];
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
            new BashCommentPattern(),

            // VALUES
            new SingleQuoteValuePattern(),
            new DoubleQuoteValuePattern(),

            // DIRECTIVES
            new NginxDirectivePattern(),

            // BOOLEANS
            new NginxBooleanPattern(),

            // VARIABLES
            new NginxVariablePattern(),

            // OPERATORS
            new NginxOperatorPattern(),

            // NUMBERS
            new BashNumberPattern(),
        ];
    }
}
