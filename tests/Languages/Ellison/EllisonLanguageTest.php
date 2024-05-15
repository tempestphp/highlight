<?php

declare(strict_types=1);

namespace Languages\Gdscript;

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
            ['This is a simple sentence', "<p><span class='hl-simple-sentence'>This is a simple sentence. </span></p>"],
            ['This is a complex sentence because it includes longer, more complex words', "<p><span class='hl-moderate-sentence'>This is a complex sentence because it includes longer, more complex words. </span></p>"],
            ['This is a complex sentence because it includes longer words of greater complexity, and an altogether unbearable length', "<p><span class='hl-complex-sentence'>This is a complex sentence because it includes longer words of greater complexity, and an altogether unbearable length. </span></p>"],
            ['This sentence was made by me', "<p><span class='hl-simple-sentence'>This sentence <span class='hl-passive-phrase'>was made</span> by me. </span></p>"],
            ['This sentence is conceivably awful', "<p><span class='hl-simple-sentence'>This sentence is <span class='hl-adverb-phrase'>conceivably</span> awful. </span></p>"],
            ['There are multiple problems', "<p><span class='hl-simple-sentence'>There are <span class='hl-complex-phrase'>multiple</span> problems. </span></p>"],
            ['I believe this sucks', "<p><span class='hl-simple-sentence'><span class='hl-qualified-phrase'>I believe</span> this sucks. </span></p>"],
        ];
    }
}
