<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ellison\Injections;

use AC\Ellison\Ellison;
use Tempest\Highlight\Escape;
use Tempest\Highlight\Highlighter;
use Tempest\Highlight\Injection;
use Tempest\Highlight\IsInjection;

final readonly class ParserInjection implements Injection
{
    use IsInjection;

    public function getPattern(): string
    {
        return '(?<match>(.|\n)*)';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        $ellison = new Ellison();
        $parsed = [];
        $paragraphs = preg_split('/\R/u', trim($content));

        foreach ($paragraphs as $paragraph) {
            $parsedParagraph = '';

            $sentences = $ellison->getSentenceDifficulty($paragraph);

            foreach ($sentences as $sentence) {
                ['text' => $text, 'type' => $type] = $sentence;

                $text = trim($text);

                $parsedParagraph .=
                    Escape::tokens("<span class='hl-{$type}-sentence'>")
                    . trim($this->parseSentence($ellison, $text), ' .')
                    . '. '
                    . Escape::tokens("</span>");
            }

            $parsed[] = $parsedParagraph;
        }

        return implode(PHP_EOL, $parsed);
    }

    private function parseSentence(Ellison $ellison, string $sentence): string
    {
        $problems = [
            ...$ellison->getPassivePhrases($sentence),
            ...$ellison->getAdverbPhrases($sentence),
            ...$ellison->getComplexPhrases($sentence),
            ...$ellison->getQualifiedPhrases($sentence),
        ];

        foreach ($problems as $problem) {
            $sentence = preg_replace(
                "/" . preg_quote($problem['text']) . "/i",
                Escape::tokens("<span class='hl-{$problem['type']}-phrase'>") . $problem['text'] . Escape::tokens("</span>"),
                $sentence,
            );
        }

        return $sentence;
    }
}
