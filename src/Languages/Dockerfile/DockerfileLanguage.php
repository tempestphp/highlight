<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Dockerfile;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Dockerfile\Patterns\CommentPattern;
use Tempest\Highlight\Languages\Dockerfile\Patterns\DoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Dockerfile\Patterns\ImageAliasKeywordPattern;
use Tempest\Highlight\Languages\Dockerfile\Patterns\ImageAliasNamePattern;
use Tempest\Highlight\Languages\Dockerfile\Patterns\ImageNamePattern;
use Tempest\Highlight\Languages\Dockerfile\Patterns\ImageTagPattern;
use Tempest\Highlight\Languages\Dockerfile\Patterns\KeywordPattern;
use Tempest\Highlight\Languages\Dockerfile\Patterns\SingleQuoteValuePattern;

class DockerfileLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'dockerfile';
    }

    #[Override]
    public function getAliases(): array
    {
        return [
            'docker',
        ];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            new KeywordPattern('ADD'),
            new KeywordPattern('ARG'),
            new KeywordPattern('CMD'),
            new KeywordPattern('COPY'),
            new KeywordPattern('ENTRYPOINT'),
            new KeywordPattern('ENV'),
            new KeywordPattern('EXPOSE'),
            new KeywordPattern('FROM'),
            new KeywordPattern('HEALTHCHECK'),
            new KeywordPattern('LABEL'),
            new KeywordPattern('MAINTAINER'),
            new KeywordPattern('ONBUILD'),
            new KeywordPattern('RUN'),
            new KeywordPattern('SHELL'),
            new KeywordPattern('STOPSIGNAL'),
            new KeywordPattern('USER'),
            new KeywordPattern('VOLUME'),
            new KeywordPattern('WORKDIR'),

            new ImageNamePattern(),
            new ImageAliasKeywordPattern(),
            new ImageAliasNamePattern(),
            new ImageTagPattern(),
            new SingleQuoteValuePattern(),
            new DoubleQuoteValuePattern(),
            new CommentPattern(),
        ];
    }
}
