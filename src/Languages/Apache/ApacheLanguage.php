<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Apache;

use Override;
use Tempest\Highlight\Languages\Apache\Patterns\ApacheCloseTagPattern;
use Tempest\Highlight\Languages\Apache\Patterns\ApacheCommentPattern;
use Tempest\Highlight\Languages\Apache\Patterns\ApacheDirectivePattern;
use Tempest\Highlight\Languages\Apache\Patterns\ApacheFlagPattern;
use Tempest\Highlight\Languages\Apache\Patterns\ApacheOpenTagPattern;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Php\Patterns\DoubleQuoteValuePattern;

final class ApacheLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'apache';
    }

    #[Override]
    public function getAliases(): array
    {
        return [
            'apacheconf',
            'htaccess',
        ];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new ApacheCommentPattern(),
            new ApacheDirectivePattern(),
            new ApacheOpenTagPattern(),
            new ApacheCloseTagPattern(),
            new ApacheFlagPattern(),
            new DoubleQuoteValuePattern(),
        ];
    }
}
