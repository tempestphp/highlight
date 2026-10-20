<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Ruby;

final class RubyLexer
{
    private const string OPERATOR_METHOD = '(?:\[\]=?|<=>|===?|=~|!=|!~|\*\*|[-+!~]@|<<|>>|<=|>=|[-+*\/%<>!~^&|`])';

    private const string START = '/^=begin(?=\s|$)(*MARK:begin)|^__END__\r?$(*MARK:data)|(?:\$[^\w\s]|(?<![\w)\]}?])\?(?:\\\\.|[^\s\\\\])(?!\w)|\bdef\s+(?:[A-Za-z_][\w:]*\.)?' . self::OPERATOR_METHOD . '|\b(?:alias|undef)\s+(?:[A-Za-z_]\w*[?!=]?\s+)?' . self::OPERATOR_METHOD . ')(*MARK:skip)|(?<![\w:]):' . self::OPERATOR_METHOD . '(*MARK:operatorSymbol)|#(*MARK:comment)|(?<![\w:]):(?=["\'])(*MARK:symbol)|["\'`](*MARK:string)|%(?:[qQwWiIrsx][^\w\s]|[^\w\s=])(*MARK:percent)|<<[~-]?[\w"\'`](*MARK:heredoc)|\/(*MARK:regex)/m';

    private const int MAX_INTERPOLATION_LENGTH = 1024;

    private const int MAX_NESTING = 8;

    private const string REGEX_CONTEXT = '(,=~!&|^?:;[{+-*%<>';

    private const string CHARACTER_LITERAL = '/\G(?<![\w)\]}?])\?(?:\\\\.|[^\s\\\\])(?!\w)/';

    private const string REGEX_FLAGS = 'eimnosux';

    private const string HEREDOC_OPENER = '<<(?<indent>[~-]?)(?:(?<quote>["\'`])(?<quoted>[^\n]+?)\k<quote>|(?<bare>[A-Za-z_]\w*))';

    private const array PERCENT_DELIMITERS = ['(' => ')', '[' => ']', '{' => '}', '<' => '>'];

    private const array EXPRESSION_KEYWORDS = ['and', 'begin', 'break', 'case', 'do', 'else', 'elsif', 'if', 'in', 'next', 'not', 'or', 'rescue', 'return', 'then', 'unless', 'until', 'when', 'while', 'yield'];

    private const int MAX_INDEXED_LABEL_LENGTH = 64;

    private const int MAX_LAZILY_INDEXED_LABELS = 32;

    private const int MAX_LINE_LITERALS = 64;

    /** @var list<array{int, int}> */
    private array $lineLiterals = [];

    /** @var array<int, ?int> */
    private array $delimitedEnds = [];

    /** @var array<int, ?int> */
    private array $regexEnds = [];

    /** @var array<int, ?int> */
    private array $interpolationEnds = [];

    private static ?string $lastContent = null;

    private static array $lastLiterals = [];

    private static ?string $lastCode = null;

    /**
     * @return array{comment: list<array{string, int}>, heredoc: list<array{string, int}>, percent: list<array{string, int}>, regex: list<array{string, int}>, string: list<array{string, int}>, symbol: list<array{string, int}>}
     */
    public function lex(string $content): array
    {
        if ($content !== self::$lastContent) {
            self::$lastLiterals = $this->scan($content);
            self::$lastContent = $content;
            self::$lastCode = null;
        }

        return self::$lastLiterals;
    }

    public function code(string $content): string
    {
        $literals = $this->lex($content);

        if (self::$lastCode !== null) {
            return self::$lastCode;
        }

        $regions = array_merge(...array_values($literals));

        usort($regions, static fn (array $a, array $b): int => $a[1] <=> $b[1]);

        $parts = [];
        $cursor = 0;

        foreach ($regions as [$value, $offset]) {
            $parts[] = substr($content, $cursor, $offset - $cursor);
            $parts[] = str_contains($value, "\n") ? preg_replace('/[^\n]/', "\0", $value) : str_repeat("\0", strlen($value));
            $cursor = $offset + strlen($value);
        }

        $parts[] = substr($content, $cursor);

        return self::$lastCode = implode('', $parts);
    }

    private function scan(string $content): array
    {
        $literals = ['comment' => [], 'heredoc' => [], 'percent' => [], 'regex' => [], 'string' => [], 'symbol' => []];
        $context = new RubyLiteralContext($content);
        $terminators = ['exact' => [], 'indented' => [], 'complete' => false];
        $pendingHeredocs = [];
        $this->lineLiterals = [];
        $this->delimitedEnds = [];
        $this->regexEnds = [];
        $this->interpolationEnds = [];
        $length = strlen($content);
        $offset = 0;

        while ($offset < $length) {
            $found = preg_match(self::START, $content, $match, PREG_OFFSET_CAPTURE, $offset);

            if ($pendingHeredocs !== []) {
                $newline = strpos($content, "\n", $offset);

                if ($newline !== false && (! $found || $newline < $match[0][1])) {
                    $offset = $this->consumeHeredocs($content, $newline + 1, $pendingHeredocs, $terminators, $literals, $context);
                    $pendingHeredocs = [];

                    continue;
                }
            }

            if (! $found) {
                break;
            }

            [$token, $start] = $match[0];
            $type = $match['MARK'];
            $offset = $start + 1;

            if ($type === 'begin') {
                $end = preg_match('/^=end(?=\s|$)[^\n]*/m', $content, $endMatch, PREG_OFFSET_CAPTURE, $start)
                    ? $endMatch[0][1] + strlen($endMatch[0][0])
                    : $length;

                $offset = $this->add($literals, 'comment', $content, $start, $end, $context);
            } elseif ($type === 'operatorSymbol') {
                if (! $this->closesTernary($content, $start)) {
                    $offset = $this->add($literals, 'symbol', $content, $start, $start + strlen($token), $context);
                }
            } elseif ($type === 'data') {
                $offset = $this->add($literals, 'comment', $content, $start, $length, $context);
            } elseif ($type === 'skip') {
                $offset = $start + strlen($token);
            } elseif ($type === 'comment') {
                $end = strpos($content, "\n", $start);

                $offset = $this->add($literals, 'comment', $content, $start, $end === false ? $length : $end, $context);
            } elseif ($type === 'symbol') {
                if (($end = $this->findStringEnd($content, $start + 1)) !== null) {
                    $offset = $this->add($literals, 'symbol', $content, $start, $end, $context);
                }
            } elseif ($type === 'string') {
                if (($end = $this->findStringEnd($content, $start)) !== null) {
                    $offset = $this->add($literals, 'string', $content, $start, $end, $context);

                    $this->scheduleInterpolatedHeredocs($content, $start, $end, $terminators, $pendingHeredocs);
                }
            } elseif ($type === 'percent') {
                if ($context->startsLiteralAt($start) && ($end = $this->findPercentLiteralEnd($content, $start)) !== null) {
                    $offset = $this->add($literals, 'percent', $content, $start, $end, $context);

                    if ($content[$start + 1] === 'r') {
                        $this->bindNamedCaptures(substr($content, $start, $end - $start), $content, $end, $context);
                    }
                }
            } elseif ($type === 'heredoc') {
                $heredoc = $this->matchHeredocOpener($content, $start, $context, $terminators);

                if ($heredoc !== null) {
                    $pendingHeredocs[] = $heredoc;
                    $offset = $start + strlen($heredoc['opener']);
                } else {
                    $offset = $start + 2;
                }
            } elseif ($this->startsRegexAt($content, $start, $context) && ($end = $this->findRegexEnd($content, $start)) !== null) {
                $offset = $this->add($literals, 'regex', $content, $start, $end, $context);

                $this->bindNamedCaptures(substr($content, $start, $end - $start), $content, $end, $context);
            }
        }

        return $literals;
    }

    private function consumeHeredocs(string $content, int $bodyStart, array $heredocs, array &$terminators, array &$literals, RubyLiteralContext $context): int
    {
        $offset = $bodyStart;

        foreach ($heredocs as $heredoc) {
            $terminatorStart = $this->findTerminator($terminators, $content, $heredoc, $bodyStart);

            if ($terminatorStart === null) {
                continue;
            }

            $terminatorEnd = strpos($content, "\n", $terminatorStart);
            $terminatorEnd = $terminatorEnd === false ? strlen($content) : $terminatorEnd;

            if ($heredoc['opener'] !== null) {
                $literals['heredoc'][] = [$heredoc['opener'], $heredoc['offset']];
            }

            $this->add($literals, 'heredoc', $content, $bodyStart, $terminatorEnd, $context);

            $offset = $terminatorEnd;
            $bodyStart = $terminatorEnd + 1;
        }

        return $offset;
    }

    private function matchHeredocOpener(string $content, int $start, RubyLiteralContext $context, array &$terminators): ?array
    {
        if (! $context->startsLiteralAt($start) || ! preg_match('/\G' . self::HEREDOC_OPENER . '/', $content, $match, 0, $start)) {
            return null;
        }

        $heredoc = [
            'opener' => $match[0],
            'offset' => $start,
            'label' => ($match['bare'] ?? '') !== '' ? $match['bare'] : $match['quoted'],
            'indented' => $match['indent'] !== '',
            'raw' => ($match['quote'] ?? '') === "'",
        ];

        $lineEnd = strpos($content, "\n", $start);

        if ($lineEnd === false || $this->findTerminator($terminators, $content, $heredoc, $lineEnd + 1) === null) {
            return null;
        }

        return $heredoc;
    }

    private function scheduleInterpolatedHeredocs(string $content, int $start, int $end, array &$terminators, array &$pendingHeredocs): void
    {
        $literal = substr($content, $start, $end - $start);

        if (! str_contains($literal, '<<') || ! preg_match_all('/#\{[^}]*?(?<=[(,=\s])(?<heredoc>' . self::HEREDOC_OPENER . ')/', $literal, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
            return;
        }

        $lineEnd = strpos($content, "\n", $end);

        foreach ($matches as $match) {
            $heredoc = [
                'opener' => null,
                'offset' => $start + $match['heredoc'][1],
                'label' => ($match['bare'][0] ?? '') !== '' ? $match['bare'][0] : $match['quoted'][0],
                'indented' => $match['indent'][0] !== '',
                'raw' => ($match['quote'][0] ?? '') === "'",
            ];

            if ($lineEnd !== false && $this->findTerminator($terminators, $content, $heredoc, $lineEnd + 1) !== null) {
                $pendingHeredocs[] = $heredoc;
            }
        }
    }

    private function startsRegexAt(string $content, int $start, RubyLiteralContext $context): bool
    {
        if (! $context->startsLiteralAt($start)) {
            return false;
        }

        $before = preg_replace('/\\\\\r?\n[ \t]*/', ' ', substr($content, max(0, $start - 64), min(64, $start)));

        $word = preg_match('/(?<word>[\w?!]+)[ \t]*\z/', $before, $match) ? $match['word'] : null;
        $afterKeyword = $word !== null && $this->isExpressionKeyword($before, $word);

        if (($content[$start + 1] ?? '') === '=' && ! $afterKeyword && preg_match('/[\w)\]}?!][ \t]*\z/', $before)) {
            return false;
        }

        if (! ctype_space($content[$start + 1] ?? ' ')) {
            return true;
        }

        if (! preg_match('/[\w?!][ \t]+\z/', $before)) {
            return true;
        }

        return $afterKeyword;
    }

    private function isExpressionKeyword(string $before, string $word): bool
    {
        return in_array($word, self::EXPRESSION_KEYWORDS, true) && ! preg_match('/(?:\.|::)\s*' . $word . '[ \t]*\z/', $before);
    }

    private function bindNamedCaptures(string $regex, string $content, int $end, RubyLiteralContext $context): void
    {
        if (str_contains($regex, '#{') || ! preg_match('/\G[ \t]*=~/', $content, $match, 0, $end)) {
            return;
        }

        preg_match_all('/\(\?(?:<(?<name>[a-z_]\w*)>|\'(?<quotedName>[a-z_]\w*)\')/', $regex, $captures, PREG_SET_ORDER);

        foreach ($captures as $capture) {
            $context->bind(($capture['name'] ?? '') !== '' ? $capture['name'] : $capture['quotedName'], $end);
        }
    }

    private function closesTernary(string $content, int $start): bool
    {
        $lineStart = $this->lineStart($content, $start);
        $line = substr($content, $lineStart, $start - $lineStart);

        foreach ($this->lineLiterals as [$literalStart, $literalEnd]) {
            if ($literalStart >= $lineStart && $literalEnd <= $start) {
                $line = substr_replace($line, str_repeat('x', $literalEnd - $literalStart), $literalStart - $lineStart, $literalEnd - $literalStart);
            }
        }

        if (preg_match_all('/(?<=\s)\?(?=\s)/', $line, $questionMarks, PREG_OFFSET_CAPTURE) <= preg_match_all('/(?<=\s):(?=\s)/', $line)) {
            return false;
        }

        $branch = rtrim(substr($line, end($questionMarks[0])[1] + 1));

        if ($branch === '' || str_contains('([{,|', $branch[-1])) {
            return false;
        }

        return preg_match_all('/[(\[{]/', $branch) <= preg_match_all('/[)\]}]/', $branch);
    }

    private function lineStart(string $content, int $offset): int
    {
        $windowStart = max(0, $offset - 256);

        return $windowStart + (int) strrpos("\n" . substr($content, $windowStart, $offset - $windowStart), "\n");
    }

    private function findPercentLiteralEnd(string $content, int $start, bool $extendsToEnd = true, int $nesting = 0, ?int $limit = null): ?int
    {
        if (! preg_match('/\G%(?:(?<type>[qQwWiIrsx])(?<typedOpen>[^\w\s])|(?<open>[^\w\s=]))/', $content, $match, 0, $start)) {
            return null;
        }

        $type = $match['type'] ?? '';
        $open = ($match['typedOpen'] ?? '') !== '' ? $match['typedOpen'] : $match['open'];
        $interpolates = ! in_array($type, ['q', 'w', 'i', 's'], true);

        $end = $this->findDelimitedEnd($content, $start + strlen($match[0]), $open, self::PERCENT_DELIMITERS[$open] ?? $open, $interpolates, $nesting, $limit);

        if ($end === null) {
            return $extendsToEnd ? strlen($content) : null;
        }

        return $type === 'r' ? $end + strspn($content, self::REGEX_FLAGS, $end) : $end;
    }

    private function findStringEnd(string $content, int $start, int $nesting = 0, ?int $limit = null): ?int
    {
        $quote = $content[$start];

        return $this->findDelimitedEnd($content, $start + 1, $quote, $quote, $quote !== "'", $nesting, $limit);
    }

    private function findDelimitedEnd(string $content, int $offset, string $open, string $close, bool $interpolates, int $nesting = 0, ?int $limit = null): ?int
    {
        if (! array_key_exists($offset, $this->delimitedEnds)) {
            $this->delimitedEnds[$offset] = $this->scanDelimited($content, $offset, $open, $close, $interpolates, $nesting, $limit);
        }

        return $this->delimitedEnds[$offset];
    }

    private function scanDelimited(string $content, int $offset, string $open, string $close, bool $interpolates, int $nesting, ?int $limit): ?int
    {
        $stops = '\\' . $open . $close . ($interpolates ? '#' : '');
        $length = $limit ?? strlen($content);
        $depth = 1;

        while (($offset += strcspn($content, $stops, $offset, $length - $offset)) < $length) {
            $character = $content[$offset];

            if ($character === $close) {
                if (--$depth === 0) {
                    return $offset + 1;
                }

                $offset++;
            } elseif ($character === '\\') {
                $offset += 2;
            } elseif ($character === $open) {
                $depth++;
                $offset++;
            } else {
                $offset = $this->findInterpolationEnd($content, $offset, $nesting + 1, $limit) ?? $offset + 1;
            }
        }

        return null;
    }

    private function findRegexEnd(string $content, int $start, int $nesting = 0, ?int $limit = null): ?int
    {
        if (! array_key_exists($start, $this->regexEnds)) {
            $this->regexEnds[$start] = $this->scanRegex($content, $start, $nesting, $limit);
        }

        return $this->regexEnds[$start];
    }

    private function scanRegex(string $content, int $start, int $nesting, ?int $limit): ?int
    {
        $length = $limit ?? strlen($content);
        $offset = $start + 1;

        while (($offset += strcspn($content, '/\\[#', $offset, $length - $offset)) < $length) {
            $character = $content[$offset];

            if ($character === '/') {
                return $offset + 1 + strspn($content, self::REGEX_FLAGS, $offset + 1);
            }

            if ($character === '\\') {
                $offset += 2;
            } elseif ($character === '[') {
                $offset = $this->findCharacterClassEnd($content, $offset, $nesting, $length);
            } else {
                $offset = $this->findInterpolationEnd($content, $offset, $nesting + 1, $limit) ?? $offset + 1;
            }
        }

        return null;
    }

    private function findCharacterClassEnd(string $content, int $offset, int $nesting, int $length): int
    {
        $depth = 0;

        while (($offset += strcspn($content, "[]\\#\n", $offset, $length - $offset)) < $length) {
            $character = $content[$offset];

            if ($character === "\n") {
                return $offset;
            }

            if ($character === '\\') {
                $offset += 2;

                continue;
            }

            if ($character === '#') {
                $offset = $this->findInterpolationEnd($content, $offset, $nesting + 1, $length) ?? $offset + 1;

                continue;
            }

            $depth += $character === '[' ? 1 : -1;
            $offset++;

            if ($depth === 0) {
                return $offset;
            }
        }

        return $length;
    }

    private function findInterpolationEnd(string $content, int $offset, int $nesting, ?int $limit = null): ?int
    {
        if ($nesting > self::MAX_NESTING || ($content[$offset + 1] ?? '') !== '{') {
            return null;
        }

        if (! array_key_exists($offset, $this->interpolationEnds)) {
            $limit = min($limit ?? strlen($content), $offset + 2 + self::MAX_INTERPOLATION_LENGTH);

            $this->interpolationEnds[$offset] = $this->scanInterpolation($content, $offset + 2, $nesting, $limit);
        }

        return $this->interpolationEnds[$offset];
    }

    private function scanInterpolation(string $content, int $start, int $nesting, int $limit): ?int
    {
        $offset = $start;
        $depth = 1;

        while (($offset += strcspn($content, "{}\"'`/%#?$\\", $offset, $limit - $offset)) < $limit) {
            $character = $content[$offset];

            if ($character === '?') {
                $offset += preg_match(self::CHARACTER_LITERAL, $content, $match, 0, $offset) ? strlen($match[0]) : 1;
            } elseif ($character === '$') {
                $offset += preg_match('/\G\$[^\w\s]/', $content, $match, 0, $offset) ? 2 : 1;
            } elseif ($character === '{') {
                $depth++;
                $offset++;
            } elseif ($character === '}') {
                if (--$depth === 0) {
                    return $offset + 1;
                }

                $offset++;
            } elseif ($character === '\\') {
                $offset += 2;
            } elseif ($character === '#') {
                $lineEnd = strpos($content, "\n", $offset);
                $offset = $lineEnd === false ? $limit : $lineEnd;
            } elseif ($character === '/') {
                $offset = ($this->isRegexContext($content, $start, $offset) ? $this->findRegexEnd($content, $offset, $nesting, $limit) : null) ?? $offset + 1;
            } elseif ($character === '%') {
                $offset = ($this->isRegexContext($content, $start, $offset) ? $this->findPercentLiteralEnd($content, $offset, false, $nesting, $limit) : null) ?? $offset + 1;
            } elseif (($end = $this->findStringEnd($content, $offset, $nesting, $limit)) !== null) {
                $offset = $end;
            } else {
                return null;
            }
        }

        return null;
    }

    private function isRegexContext(string $content, int $start, int $offset): bool
    {
        $previous = $offset - 1;

        while ($previous >= $start && ctype_space($content[$previous])) {
            $previous--;
        }

        if ($previous < $start || str_contains(self::REGEX_CONTEXT, $content[$previous])) {
            return true;
        }

        $before = substr($content, $start, $previous + 1 - $start);

        if (preg_match('/(?<word>[a-z]+)\z/', $before, $match) && $this->isExpressionKeyword($before, $match['word'])) {
            return true;
        }

        $isCommandArgument = $previous < $offset - 1
            && ! ctype_space($content[$offset + 1] ?? ' ')
            && ($content[$offset + 1] ?? '') !== '=';

        return $isCommandArgument && (ctype_alnum($content[$previous]) || str_contains('_?!', $content[$previous]));
    }

    /**
     * @return array{exact: array<string, list<int>>, indented: array<string, list<int>>}
     */
    private function indexTerminators(string $content): array
    {
        $terminators = ['exact' => [], 'indented' => []];
        $length = strlen($content);
        $lineStart = 0;

        while ($lineStart < $length) {
            $lineEnd = strpos($content, "\n", $lineStart);
            $lineEnd = $lineEnd === false ? $length : $lineEnd;
            $indentation = strspn($content, " \t", $lineStart, $lineEnd - $lineStart);
            $label = rtrim(substr($content, $lineStart + $indentation, min(self::MAX_INDEXED_LABEL_LENGTH + 1, $lineEnd - $lineStart - $indentation)), "\r");

            if ($this->isIndexedLabel($label)) {
                $terminators['indented'][$label][] = $lineStart;

                if ($indentation === 0) {
                    $terminators['exact'][$label][] = $lineStart;
                }
            }

            $lineStart = $lineEnd + 1;
        }

        return $terminators;
    }

    private function isIndexedLabel(string $label): bool
    {
        return $label !== '' && strlen($label) <= self::MAX_INDEXED_LABEL_LENGTH && strcspn($label, " \t") === strlen($label);
    }

    private function findTerminator(array &$terminators, string $content, array $heredoc, int $from): ?int
    {
        $label = $heredoc['label'];

        if (! $terminators['complete'] && ! isset($terminators['indented'][$label]) && count($terminators['indented']) >= self::MAX_LAZILY_INDEXED_LABELS) {
            $terminators = [...$this->indexTerminators($content), 'complete' => true];
        }

        if (! isset($terminators['indented'][$label]) && (! $terminators['complete'] || ! $this->isIndexedLabel($label))) {
            preg_match_all('/^([ \t]*)' . preg_quote($label, '/') . '\r?$/m', $content, $lines, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);

            $terminators['indented'][$label] = [];
            $terminators['exact'][$label] = [];

            foreach ($lines as [[, $offset], [$indentation]]) {
                $terminators['indented'][$label][] = $offset;

                if ($indentation === '') {
                    $terminators['exact'][$label][] = $offset;
                }
            }
        }

        $offsets = $terminators[$heredoc['indented'] ? 'indented' : 'exact'][$label] ?? [];

        $low = 0;
        $high = count($offsets);

        while ($low < $high) {
            $middle = intdiv($low + $high, 2);

            if ($offsets[$middle] < $from) {
                $low = $middle + 1;
            } else {
                $high = $middle;
            }
        }

        while (($terminator = $offsets[$low] ?? null) !== null && ! $heredoc['raw'] && $this->continuesPreviousLine($content, $terminator)) {
            $low++;
        }

        return $terminator;
    }

    private function continuesPreviousLine(string $content, int $lineStart): bool
    {
        $previousLineEnd = $lineStart - 1;

        if ($previousLineEnd > 0 && $content[$previousLineEnd - 1] === "\r") {
            $previousLineEnd--;
        }

        $backslashes = 0;

        while ($previousLineEnd - $backslashes > 0 && $content[$previousLineEnd - $backslashes - 1] === '\\') {
            $backslashes++;
        }

        return $backslashes % 2 === 1;
    }

    private function add(array &$literals, string $type, string $content, int $start, int $end, RubyLiteralContext $context): int
    {
        $literals[$type][] = [substr($content, $start, $end - $start), $start];

        if (count($this->lineLiterals) >= self::MAX_LINE_LITERALS) {
            $lineStart = $this->lineStart($content, $start);
            $this->lineLiterals = array_values(array_filter($this->lineLiterals, static fn (array $literal): bool => $literal[0] >= $lineStart));
        }

        $this->lineLiterals[] = [$start, $end];

        $context->skip($start, $end);

        return $end;
    }
}
