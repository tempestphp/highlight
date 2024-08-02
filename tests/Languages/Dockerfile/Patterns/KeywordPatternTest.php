<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Dockerfile\Patterns;

use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Languages\Dockerfile\Patterns\KeywordPattern;
use Tempest\Highlight\Tests\TestsPatterns;

class KeywordPatternTest extends TestCase
{
    use TestsPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new KeywordPattern('FROM'),
            content: 'FROM image:tag',
            expected: 'FROM',
        );

        $this->assertMatches(
            pattern: new KeywordPattern('FROM'),
            content: 'FROM image:tag AS alias',
            expected: 'FROM',
        );

        $this->assertMatches(
            pattern: new KeywordPattern('FROM'),
            content: ' FROM image:tag AS alias',
            expected: 'FROM',
        );

        $this->assertMatches(
            pattern: new KeywordPattern('COPY'),
            content: <<<'DOCKERFILE'
                     FROM image:tag
                     COPY . /usr/share/nginx/html
                     DOCKERFILE,
            expected: 'COPY',
        );
    }
}
