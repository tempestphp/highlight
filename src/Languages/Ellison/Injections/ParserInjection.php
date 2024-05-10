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
        return '(?<match>.*)';
    }

    public function parseContent(string $content, Highlighter $highlighter): string
    {
        $parsed = '';
        $paragraphs = preg_split("/\n+\w*\n+/", $content);

        foreach ($paragraphs as $i => $paragraph) {
            $parsed .= Escape::tokens("<p>");

            $ellison = new Ellison();
            $sentences = $ellison->getSentenceDifficulty($content);

            foreach ($sentences as $sentence) {
                ['text' => $text, 'type' => $type] = $sentence;

                $text = trim($text);

                $offset = mb_stripos($content, $text);

                $parsed .= Escape::tokens("<span class='hl-{$type}-sentence'>").trim($this->parseSentence($ellison, $text), ' .').'. '.Escape::tokens("</span>");

                $content = mb_substr($content, $offset + mb_strlen($text));
            }

            $parsed .= Escape::tokens("</p>");
        }

        return $parsed;
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
                "/".preg_quote($problem['text'])."/i",
                Escape::tokens("<span class='hl-{$problem['type']}-phrase'>").$problem['text'].Escape::tokens("</span>"),
                $sentence,
            );
        }

        return $sentence;
    }
}
