<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby;

final class RubyLiteralContext
{
    private const string KEYWORD_BINDINGS = '/\bdef\s+(?:[\w:]+\.)?[^\s(;]+\s*\((?<parameters>(?:[^()]++|\((?:[^()]++|\([^()]*+\))*+\))*+)\)|\bdef\s+(?:[\w:]+\.)?[^\s(;]+[ \t]+(?<bareParameters>(?!=)[^\n;]+)|(?<scope>(?<![.:@$])\b(?:def|class|module)(?![\w?!:]))|->\s*\((?<lambdaParameters>(?:[^()]++|\([^()]*+\))*+)\)|->[ \t]*(?<bareLambdaParameters>[a-z_]\w*(?:[ \t]*,[ \t]*[a-z_]\w*)*)|(?:\bdo|\{)\s*\|(?<blockParameters>[^|]*)\||\bfor\s+(?<loopVariables>[a-z_]\w*(?:\s*,\s*[a-z_]\w*)*)\s+in\b|\brescue\b[^\n]*?=>\s*(?<exception>[a-z_]\w*)|;[ \t]*(?<statementMultipleAssignment>\(?\*?[a-z_]\w*(?:[ \t]*,[ \t]*\(?\*?[a-z_]\w*\)?)+\)?)[ \t]*=(?![=~>])|(?<![.:\w@$])in[ \t]+(?<pattern>(?:[^\n;(\[{]++|\((?:[^()]++|\((?:[^()]++|\([^()]*+\))*+\))*+\)|\[(?:[^\[\]]++|\[(?:[^\[\]]++|\[[^\[\]]*+\])*+\])*+\]|\{(?:[^{}]++|\{(?:[^{}]++|\{[^{}]*+\})*+\})*+\})+)|(?<rightward>=>)[ \t]*(?<rightwardPattern>(?:[^\n;(\[{]++|\((?:[^()]++|\((?:[^()]++|\([^()]*+\))*+\))*+\)|\[(?:[^\[\]]++|\[(?:[^\[\]]++|\[[^\[\]]*+\])*+\])*+\]|\{(?:[^{}]++|\{(?:[^{}]++|\{[^{}]*+\})*+\})*+\})+)/m';

    private const string LINE_MULTIPLE_ASSIGNMENTS = '/^[ \t]*+(?<multipleAssignment>\(?\*?[a-z_]\w*(?:[ \t]*,[ \t]*\(?\*?[a-z_]\w*\)?)+\)?)[ \t]*=(?![=~>])/m';

    private const string ASSIGNMENTS = '/(?<![\w@$.:])(?<!def )(?<assignment>[a-z_]\w*+)\s*+(?:\|\||&&|\*\*|<<|>>|[-+*\/%|&^])?=(?![=~>])/';

    private const string UNCLOSED_PARAMETERS = '/(?<declaration>\bdef\s+(?:[\w:]+\.)?[^\s(;]+\s*|->\s*)\((?<parameters>(?:[^()]++|\((?:[^()]++|\([^()]*+\))*+\))*+)\z/';

    private const int MAX_UNCLOSED_LENGTH = 512;

    private const int MAX_PENDING_LITERALS = 65536;

    private const array BINDING_GROUPS = ['parameters', 'bareParameters', 'lambdaParameters', 'bareLambdaParameters', 'blockParameters', 'loopVariables', 'exception'];

    private const string PATTERN_CAPTURES = '/(?<![\w.:@$^])(?:(?<key>[a-z_]\w*):(?=\s*(?:[,})\]]|$))|(?<name>[a-z_]\w*)(?![\w(:?!]|\s*\())/';

    private const array VALUES = ['self', 'nil', 'true', 'false', '__FILE__', '__LINE__', '__ENCODING__'];

    /** @var list<int> */
    private array $scopes = [];

    /** @var array<string, list<int>> */
    private array $bindings = [];

    /** @var array<string, list<int>> */
    private array $capturedBindings = [];

    /** @var list<int> */
    private array $literalStarts = [];

    /** @var list<int> */
    private array $literalEnds = [];

    private int $collectedUpTo = 0;

    private ?int $provisionalFrom = null;

    /** @var list<array{?string, int}> */
    private array $provisional = [];

    public function __construct(
        private readonly string $content,
    ) {
    }

    public function skip(int $start, int $end): void
    {
        $this->literalStarts[] = $start;
        $this->literalEnds[] = $end;

        if (count($this->literalStarts) > self::MAX_PENDING_LITERALS) {
            $this->collectBindings($end);
        }
    }

    public function bind(string $name, int $offset): void
    {
        $this->capturedBindings[$name][] = $offset;
    }

    public function startsLiteralAt(int $offset): bool
    {
        $before = substr($this->content, max(0, $offset - 64), min(64, $offset));
        $before = preg_replace('/\\\\\r?\n[ \t]*/', ' ', $before);

        if (preg_match('/[\w)\]}"\'`]\z/', $before)) {
            return false;
        }

        if (! preg_match('/(?<receiver>&?\.|::)?(?<operand>[@$]*\w+[?!]?|[)\]}"\'`])[ \t]+\z/', $before, $matches)) {
            return true;
        }

        $operand = $matches['operand'];

        if ($matches['receiver'] !== '' || preg_match('/^[a-z_]\w*[?!]$/', $operand)) {
            return true;
        }

        if (! preg_match('/^[a-z_]\w*$/', $operand) || in_array($operand, self::VALUES, true)) {
            return false;
        }

        $this->collectBindings($offset);

        return ! $this->isBound($operand, $offset);
    }

    private function collectBindings(int $offset): void
    {
        if ($offset <= $this->collectedUpTo) {
            return;
        }

        if ($this->provisionalFrom !== null) {
            $this->rollbackProvisional();
        }

        $chunkStart = $this->collectedUpTo;
        $chunk = $this->maskedChunk($chunkStart, $offset);
        $events = [];

        preg_match_all(self::KEYWORD_BINDINGS, $chunk, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE | PREG_UNMATCHED_AS_NULL);

        foreach ($matches as $match) {
            if ($match['parameters'][0] !== null || $match['bareParameters'][0] !== null || $match['scope'][0] !== null) {
                $events[] = [null, $match[0][1]];
            }

            foreach (self::BINDING_GROUPS as $group) {
                if ($match[$group][0] !== null) {
                    $this->collectNames($match[$group][0], $match[$group][1], $events);
                }
            }

            if ($match['statementMultipleAssignment'][0] !== null) {
                $this->collectNames(strtr($match['statementMultipleAssignment'][0], '()', '  '), $match['statementMultipleAssignment'][1], $events);
            }

            if ($match['pattern'][0] !== null) {
                $this->collectPatternCaptures($match['pattern'][0], $match['pattern'][1], $events);
            }

            if ($match['rightwardPattern'][0] !== null && $this->isStatementLevel($chunk, $match['rightward'][1])) {
                $this->collectPatternCaptures($match['rightwardPattern'][0], $match['rightwardPattern'][1], $events);
            }
        }

        preg_match_all(self::LINE_MULTIPLE_ASSIGNMENTS, $chunk, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches['multipleAssignment'] as [$names, $namesOffset]) {
            $this->collectNames(strtr($names, '()', '  '), $namesOffset, $events);
        }

        preg_match_all(self::ASSIGNMENTS, $chunk, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches['assignment'] as [$name, $nameOffset]) {
            $events[] = [$name, $nameOffset];
        }

        $unclosedStatement = $this->findUnclosedStatement($chunk);

        if ($unclosedStatement !== null && preg_match(self::UNCLOSED_PARAMETERS, $chunk, $unclosed, PREG_OFFSET_CAPTURE, $unclosedStatement)) {
            if (str_starts_with($unclosed['declaration'][0], 'def')) {
                $events[] = [null, $unclosed[0][1]];
            }

            $this->collectNames($unclosed['parameters'][0], $unclosed['parameters'][1], $events);
        }

        usort($events, static fn (array $a, array $b): int => $a[1] <=> $b[1]);

        foreach ($events as [$name, $eventOffset]) {
            $this->register($name, $chunkStart + $eventOffset);
        }

        $this->collectedUpTo = $offset;

        if ($unclosedStatement !== null) {
            $this->provisionalFrom = $chunkStart + $unclosedStatement;

            $kept = array_keys(array_filter($this->literalEnds, fn (int $end): bool => $end > $this->provisionalFrom));
            $this->literalStarts = array_values(array_intersect_key($this->literalStarts, array_flip($kept)));
            $this->literalEnds = array_values(array_intersect_key($this->literalEnds, array_flip($kept)));
            $this->provisional = array_values(array_filter($this->provisional, fn (array $entry): bool => $entry[1] >= $this->provisionalFrom));
        } else {
            $this->literalStarts = [];
            $this->literalEnds = [];
            $this->provisional = [];
        }
    }

    private function findUnclosedStatement(string $chunk): ?int
    {
        $windowStart = max(0, strlen($chunk) - self::MAX_UNCLOSED_LENGTH);
        $opener = $this->findUnclosedOpener($chunk, $windowStart, strlen($chunk), true);

        if ($opener === null) {
            return null;
        }

        $lineStart = strrpos(substr($chunk, $windowStart, $opener - $windowStart), "\n");

        return $lineStart === false ? $windowStart : $windowStart + $lineStart + 1;
    }

    private function findUnclosedOpener(string $text, int $start, int $end, bool $outermost): ?int
    {
        preg_match_all('/[()\[\]{}]/', substr($text, $start, $end - $start), $brackets, PREG_OFFSET_CAPTURE);

        $depth = 0;
        $unclosed = null;

        foreach (array_reverse($brackets[0]) as [$bracket, $offset]) {
            if (str_contains(')]}', $bracket)) {
                $depth++;
            } elseif ($depth > 0) {
                $depth--;
            } else {
                $unclosed = $start + $offset;

                if (! $outermost) {
                    return $unclosed;
                }
            }
        }

        return $unclosed;
    }

    private function maskedChunk(int $start, int $end): string
    {
        $parts = [];
        $cursor = $start;

        foreach ($this->literalStarts as $index => $literalStart) {
            $literalStart = max($literalStart, $cursor);
            $literalEnd = $this->literalEnds[$index];
            $parts[] = substr($this->content, $cursor, $literalStart - $cursor);
            $literal = substr($this->content, $literalStart, $literalEnd - $literalStart);
            $parts[] = str_contains($literal, "\n") ? preg_replace('/[^\n]/', '0', $literal) : str_repeat('0', strlen($literal));
            $cursor = $literalEnd;
        }

        $parts[] = substr($this->content, $cursor, $end - $cursor);

        return implode('', $parts);
    }

    private function collectNames(string $names, int $offset, array &$events): void
    {
        do {
            $names = preg_replace('/(^|,)(\s*)\(([^()]*)\)/', '$1$2$3', $names, -1, $replacements);
        } while ($replacements > 0);

        do {
            $names = preg_replace('/\([^()]*\)|\[[^\[\]]*\]|\{[^{}]*\}/', '', $names, -1, $replacements);
        } while ($replacements > 0);

        preg_match_all('/(?:^|,)\s*[*&]{0,2}(?<name>[a-z_]\w*)/', $names, $matches);

        foreach ($matches['name'] as $name) {
            $events[] = [$name, $offset];
        }
    }

    private function collectPatternCaptures(string $pattern, int $offset, array &$events): void
    {
        $pattern = preg_replace('/\s(?:if|unless|then)\s.*$/', '', $pattern);

        preg_match_all(self::PATTERN_CAPTURES, $pattern, $matches, PREG_SET_ORDER | PREG_UNMATCHED_AS_NULL);

        foreach ($matches as $match) {
            $name = $match['key'] ?? $match['name'];

            if (! in_array($name, self::VALUES, true)) {
                $events[] = [$name, $offset];
            }
        }
    }

    private function isStatementLevel(string $chunk, int $offset): bool
    {
        $opener = $this->findUnclosedOpener($chunk, max(0, $offset - self::MAX_UNCLOSED_LENGTH), $offset, false);

        return $opener === null || ($chunk[$opener] === '(' && ! preg_match('/[\w?!]/', $chunk[$opener - 1] ?? ' '));
    }

    private function register(?string $name, int $offset): void
    {
        if ($name === null) {
            $this->scopes[] = $offset;
        } else {
            $this->bindings[$name][] = $offset;
        }

        $this->provisional[] = [$name, $offset];
    }

    private function rollbackProvisional(): void
    {
        foreach (array_reverse($this->provisional) as [$name]) {
            if ($name === null) {
                array_pop($this->scopes);
            } else {
                array_pop($this->bindings[$name]);
            }
        }

        $this->collectedUpTo = $this->provisionalFrom;
        $this->provisionalFrom = null;
        $this->provisional = [];
    }

    private function isBound(string $name, int $offset): bool
    {
        $scopeStart = $this->lastBefore($this->scopes, $offset) ?? 0;
        $binding = max(
            $this->lastBefore($this->bindings[$name] ?? [], $offset) ?? -1,
            $this->lastBefore($this->capturedBindings[$name] ?? [], $offset) ?? -1,
        );

        return $binding >= $scopeStart;
    }

    /**
     * @param list<int> $offsets
     */
    private function lastBefore(array $offsets, int $offset): ?int
    {
        $low = 0;
        $high = count($offsets);

        while ($low < $high) {
            $middle = intdiv($low + $high, 2);

            if ($offsets[$middle] < $offset) {
                $low = $middle + 1;
            } else {
                $high = $middle;
            }
        }

        return $offsets[$low - 1] ?? null;
    }
}
