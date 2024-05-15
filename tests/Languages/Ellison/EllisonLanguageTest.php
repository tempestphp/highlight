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
            [<<<'TXT'
There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. 

All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.


TXT, <<<'TXT'
<span class='hl-complex-sentence'>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even <span class='hl-adverb-phrase'>slightly</span> believable. </span><span class='hl-complex-sentence'>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. </span>

<span class='hl-complex-sentence'>All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. </span><span class='hl-complex-sentence'>It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. </span><span class='hl-complex-sentence'>The generated Lorem Ipsum is <span class='hl-complex-phrase'>therefore</span> always free from repetition, injected humour, or non-characteristic words etc. </span>
TXT
            ],
        ];
    }
}
