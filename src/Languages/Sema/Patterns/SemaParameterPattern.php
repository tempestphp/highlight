<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema\Patterns;

use Tempest\Highlight\Languages\Sema\SemaSyntax;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\PatternTest;
use Tempest\Highlight\Tokens\TokenTypeEnum;

#[PatternTest(input: '(lambda (x y) x)', output: ['x', 'y'])]
#[PatternTest(input: '(fn [a . rest] a)', output: ['a', 'rest'])]
#[PatternTest(input: '(define (greet name) name)', output: 'name')]
#[PatternTest(input: '(defn fib "Fibonacci." (n) n)', output: 'n')]
#[PatternTest(input: '(define-values (q r) (div 7 2))', output: ['q', 'r'])]
#[PatternTest(input: '(let ((a (f 1)) (b "(")) a)', output: ['a', 'b'])]
#[PatternTest(input: '(let loop ((i 0)) i)', output: 'i')]
#[PatternTest(input: '(let (([a b] (list 1 2)) (c #\()) c)', output: ['a', 'b', 'c'])]
#[PatternTest(input: '(let ((fn (lambda (x) x))) (fn 1))', output: ['fn', 'x'])]
#[PatternTest(input: "(fn (a ; (\n b) a)", output: ['a', 'b'])]
#[PatternTest(input: '(let-values (((q r) (div 7 2))) q)', output: ['q', 'r'])]
#[PatternTest(input: '(dotimes (i 3) (when-let (x (f i)) x))', output: ['i', 'x'])]
#[PatternTest(input: '(map f xs)', output: null)]
final readonly class SemaParameterPattern implements Pattern
{
    private const array PARAMETER_FORMS = ['lambda', 'fn', 'define-values'];

    private const array FUNCTION_FORMS = ['defn', 'defun', 'defmacro'];

    private const array BINDING_FORMS = ['let', 'let*', 'letrec', 'let-values', 'let*-values', 'do'];

    private const array SINGLE_BINDING_FORMS = ['when-let', 'if-let', 'dotimes', 'for-range', 'with-open'];

    public function match(string $content): array
    {
        $lists = $this->lists($content);
        $parameters = [];

        foreach ($lists as $id => $list) {
            if ($id !== 0) {
                array_push($parameters, ...$this->parameters($list, $lists));
            }
        }

        usort($parameters, static fn (array $a, array $b): int => $a[1] <=> $b[1]);

        return ['match' => $parameters];
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::VARIABLE;
    }

    private function lists(string $content): array
    {
        $pattern = '/(?<comment>;[^\n]*+)|(?<atom>' . SemaSyntax::STRING . '|' . SemaSyntax::CHARACTER . '|:' . SemaSyntax::SYMBOL . '*+)'
            . '|(?<open>[(\[])|(?<close>[)\]])|(?<symbol>' . SemaSyntax::SYMBOL_START . SemaSyntax::SYMBOL . '*+)|(?<other>\S)/u';

        if (preg_match_all($pattern, $content, $tokens, PREG_SET_ORDER | PREG_OFFSET_CAPTURE | PREG_UNMATCHED_AS_NULL) === false) {
            return [];
        }

        $lists = [[]];
        $stack = [0];

        foreach ($tokens as $token) {
            if ($token['comment'][0] !== null) {
                continue;
            }

            if ($token['open'][0] !== null) {
                $lists[] = [];
                $stack[] = array_key_last($lists);

                continue;
            }

            if ($token['close'][0] !== null) {
                if (count($stack) > 1) {
                    $id = array_pop($stack);
                    $lists[$stack[array_key_last($stack)]][] = ['list', $id];
                }

                continue;
            }

            $lists[$stack[array_key_last($stack)]][] = $token['symbol'][0] !== null
                ? ['symbol', $token['symbol'][0], $token['symbol'][1]]
                : ['atom'];
        }

        return $lists;
    }

    private function parameters(array $list, array $lists): array
    {
        $form = $list[0][1] ?? null;

        if (($list[0][0] ?? null) !== 'symbol') {
            return [];
        }

        if (in_array($form, self::PARAMETER_FORMS, true)) {
            return $this->symbolsOf($list[1] ?? null, $lists);
        }

        if ($form === 'define' || $form === 'def') {
            return $this->symbolsOf($list[1] ?? null, $lists, skip: 1);
        }

        if (in_array($form, self::FUNCTION_FORMS, true)) {
            $index = ($list[2][0] ?? null) === 'atom' ? 3 : 2;

            return $this->symbolsOf($list[$index] ?? null, $lists);
        }

        if (in_array($form, self::SINGLE_BINDING_FORMS, true)) {
            $binding = ($list[1][0] ?? null) === 'list' ? ($lists[$list[1][1]][0] ?? null) : null;

            return ($binding[0] ?? null) === 'symbol' ? $this->withoutDots([$binding]) : [];
        }

        if (! in_array($form, self::BINDING_FORMS, true)) {
            return [];
        }

        $bindings = ($list[1][0] ?? null) === 'symbol' ? ($list[2] ?? null) : ($list[1] ?? null);

        if (($bindings[0] ?? null) !== 'list') {
            return [];
        }

        $names = [];

        foreach ($lists[$bindings[1]] as $binding) {
            $name = $binding[0] === 'list' ? ($lists[$binding[1]][0] ?? null) : null;

            array_push($names, ...match ($name[0] ?? null) {
                'symbol' => $this->withoutDots([$name]),
                'list' => $this->allSymbolsOf($name[1], $lists),
                default => [],
            });
        }

        return $names;
    }

    private function symbolsOf(?array $element, array $lists, int $skip = 0): array
    {
        if (($element[0] ?? null) !== 'list') {
            return [];
        }

        $symbols = array_slice($lists[$element[1]], $skip);

        foreach ($symbols as $symbol) {
            if ($symbol[0] !== 'symbol') {
                return [];
            }
        }

        return $this->withoutDots($symbols);
    }

    private function allSymbolsOf(int $id, array $lists): array
    {
        $symbols = [];
        $pending = [$id];

        while ($pending !== []) {
            foreach ($lists[array_pop($pending)] as $element) {
                if ($element[0] === 'symbol') {
                    $symbols[] = $element;
                } elseif ($element[0] === 'list') {
                    $pending[] = $element[1];
                }
            }
        }

        return $this->withoutDots($symbols);
    }

    private function withoutDots(array $symbols): array
    {
        $parameters = [];

        foreach ($symbols as [, $name, $offset]) {
            if ($name !== '.' && $name !== '&') {
                $parameters[] = [$name, $offset];
            }
        }

        return $parameters;
    }
}
