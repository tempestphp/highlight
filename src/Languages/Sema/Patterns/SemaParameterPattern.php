<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '(lambda (x y) x)', output: ['x', 'y'])]
#[PatternTest(input: '(fn (a . rest) a)', output: ['a', 'rest'])]
#[PatternTest(input: '(define (greet name) name)', output: 'name')]
#[PatternTest(input: '(let ((a (f 1)) (b "(")) a)', output: ['a', 'b'])]
#[PatternTest(input: '(let loop ((i 0)) i)', output: 'i')]
#[PatternTest(input: '(lambda args args)', output: 'args')]
#[PatternTest(input: '(defn fib "Fibonacci." (n) n)', output: 'n')]
#[PatternTest(input: '(defmacro unless (test . body) test)', output: ['test', 'body'])]
#[PatternTest(input: '(map f xs)', output: null)]
final readonly class SemaParameterPattern implements Pattern
{
    private const string LIST = '\((?:[^()"]|"(?:[^"\\\\]|\\\\.)*"|(?&list))*\)';

    public function match(string $content): array
    {
        $parameters = [];

        preg_match_all('/\((?:lambda|fn)\s+(?<list>' . self::LIST . '|' . SemaSyntax::SYMBOL . '+)/u', $content, $lambdas, PREG_OFFSET_CAPTURE);

        foreach ($lambdas['list'] as [$list, $offset]) {
            array_push($parameters, ...$this->symbols($list, $offset));
        }

        preg_match_all('/\((?:defn|defun|defmacro)\s+' . SemaSyntax::SYMBOL . '+\s+(?:"(?:[^"\\\\]|\\\\.)*"\s+)?(?<list>' . self::LIST . ')/u', $content, $functions, PREG_OFFSET_CAPTURE);

        foreach ($functions['list'] as [$list, $offset]) {
            array_push($parameters, ...$this->symbols($list, $offset));
        }

        preg_match_all('/\((?:define|def)\s+\(\s*' . SemaSyntax::SYMBOL . '+(?<list>[^()]*)\)/u', $content, $definitions, PREG_OFFSET_CAPTURE);

        foreach ($definitions['list'] as [$list, $offset]) {
            array_push($parameters, ...$this->symbols($list, $offset));
        }

        preg_match_all('/\((?:let\*?|letrec|do)\s+(?:' . SemaSyntax::SYMBOL . '+\s+)?(?<list>' . self::LIST . ')/u', $content, $lets, PREG_OFFSET_CAPTURE);

        foreach ($lets['list'] as [$list, $offset]) {
            preg_match_all('/(?<list>' . self::LIST . ')/u', substr($list, 1, -1), $bindings, PREG_OFFSET_CAPTURE);

            foreach ($bindings['list'] as [$binding, $bindingOffset]) {
                array_push($parameters, ...array_slice($this->symbols($binding, $offset + 1 + $bindingOffset), 0, 1));
            }
        }

        return ['match' => $parameters];
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }

    /**
     * @return array<int, array{0: string, 1: int}>
     */
    private function symbols(string $list, int $offset): array
    {
        preg_match_all('/' . SemaSyntax::ATOM_START . '(?<match>' . SemaSyntax::SYMBOL_START . SemaSyntax::SYMBOL . '*)' . SemaSyntax::ATOM_END . '/u', $list, $matches, PREG_OFFSET_CAPTURE);

        $symbols = [];

        foreach ($matches['match'] as [$symbol, $symbolOffset]) {
            if ($symbol !== '.' && $symbol !== '&') {
                $symbols[] = [$symbol, $offset + $symbolOffset];
            }
        }

        return $symbols;
    }
}
