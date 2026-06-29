<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Http;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Http\Patterns\HttpAttributePattern;
use Tempest\Highlight\Languages\Http\Patterns\HttpCommentPattern;
use Tempest\Highlight\Languages\Http\Patterns\HttpMethodPattern;
use Tempest\Highlight\Languages\Http\Patterns\HttpStatusPattern;
use Tempest\Highlight\Languages\Http\Patterns\HttpUrlPattern;
use Tempest\Highlight\Languages\Http\Patterns\HttpVersionPattern;

class HttpLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'http';
    }

    public function getAliases(): array
    {
        return ['https'];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            // HTTP Comments
            new HttpCommentPattern(),

            // Start Line: Methods (GET, POST)
            new HttpMethodPattern(),

            // Start Line: HTTP Version (HTTP/1.1, HTTP/2)
            new HttpVersionPattern(),

            // Start Line: URL/Path
            new HttpUrlPattern(),

            // Response: Status Codes (200, 404)
            new HttpStatusPattern(),

            // Headers: Attribute names
            new HttpAttributePattern(),
        ];
    }
}
