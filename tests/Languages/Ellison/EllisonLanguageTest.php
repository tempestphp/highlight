<?php

declare(strict_types=1);

namespace Tempest\Highlight\Tests\Languages\Ellison;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tempest\Highlight\Highlighter;

class EllisonLanguageTest extends TestCase
{
    #[DataProvider('data')]
    public function test_highlight(string $content, string $expected): void
    {
        $highlighter = new Highlighter();

        $this->assertSame(
            $expected,
            $highlighter->parse($content, 'ellison'),
        );
    }

    public static function data(): array
    {
        return [
            ['This is a simple sentence', "<span class='hl-simple-sentence'>This is a simple sentence. </span>"],
            ['This is a complex sentence because it includes longer, more complex words', "<span class='hl-moderate-sentence'>This is a complex sentence because it includes longer, more complex words. </span>"],
            ['This is a complex sentence because it includes longer words of greater complexity, and an altogether unbearable length', "<span class='hl-complex-sentence'>This is a complex sentence because it includes longer words of greater complexity, and an altogether unbearable length. </span>"],
            ['This sentence was made by me', "<span class='hl-simple-sentence'>This sentence <span class='hl-passive-phrase'>was made</span> by me. </span>"],
            ['This sentence is conceivably awful', "<span class='hl-simple-sentence'>This sentence is <span class='hl-adverb-phrase'>conceivably</span> awful. </span>"],
            ['There are multiple problems', "<span class='hl-simple-sentence'>There are <span class='hl-complex-phrase'>multiple</span> problems. </span>"],
            ['I believe this sucks', "<span class='hl-simple-sentence'><span class='hl-qualified-phrase'>I believe</span> this sucks. </span>"],
        ];
    }
}
