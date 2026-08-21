<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Diff;

use Tempest\Highlight\Tokens\Token;

final readonly class DiffParser
{
    private const string GIT_METADATA_PATTERN = '/^(?:commit [0-9a-f]{7,}|(?:Author|AuthorDate|Commit|CommitDate|Date|Merge):.*|diff --(?:git|cc|combined) .+|index [0-9a-f]+(?:,[0-9a-f]+)*\.\.[0-9a-f]+(?: \d{6})?|(?:old|new) mode \d{6}|(?:deleted|new) file mode \d{6}|mode \d{6}(?:,\d{6})*\.\.\d{6}|(?:similarity|dissimilarity) index \d+%|(?:rename|copy) (?:from|to) .*)$/';

    /**
     * @return Token[]
     */
    public function parse(string $content): array
    {
        preg_match_all('/^.*$/m', $content, $matches, PREG_OFFSET_CAPTURE);

        $tokens = [];
        $pendingFileHeaders = [];
        $parentCount = 0;
        $remainingSourceLines = null;
        $remainingTargetLines = null;

        foreach ($matches[0] as $match) {
            $line = $match[0];

            if ($parentCount === 0 && $pendingFileHeaders !== []) {
                if ($this->isOldFileHeader($line)) {
                    $pendingFileHeaders[] = $match;

                    continue;
                }

                if ($this->isNewFileHeader($line)) {
                    $this->appendTokens($tokens, $pendingFileHeaders, DiffTokenType::FILE_HEADER);
                    $pendingFileHeaders = [];
                    $tokens[] = new Token(
                        offset: $match[1],
                        value: $line,
                        type: DiffTokenType::FILE_HEADER,
                    );

                    continue;
                }

                $this->appendTokens($tokens, $pendingFileHeaders, DiffTokenType::DELETION);
                $pendingFileHeaders = [];
            }

            $type = null;

            if ($this->isGitMetadata($line)) {
                $type = DiffTokenType::METADATA;
                $parentCount = 0;
            } elseif (($hunk = $this->parseHunkHeader($line)) !== null) {
                $type = DiffTokenType::HUNK_HEADER;
                $parentCount = $hunk['parentCount'];
                $remainingSourceLines = $hunk['sourceLines'];
                $remainingTargetLines = $hunk['targetLines'];
            } elseif ($parentCount > 0) {
                $type = $this->isSpecialMarker($line)
                    ? DiffTokenType::SPECIAL
                    : $this->classifyHunkLine($line, $parentCount);

                if ($parentCount === 1 && $type instanceof DiffTokenType) {
                    [$remainingSourceLines, $remainingTargetLines] = $this->consumeUnifiedLine(
                        $type,
                        $remainingSourceLines,
                        $remainingTargetLines,
                    );

                    if ($remainingSourceLines === 0 && $remainingTargetLines === 0) {
                        $parentCount = 0;
                    }
                }
            } elseif ($this->isOldFileHeader($line)) {
                $pendingFileHeaders[] = $match;

                continue;
            } else {
                $type = match (true) {
                    $this->isSpecialMarker($line) => DiffTokenType::SPECIAL,
                    str_starts_with($line, '+') => DiffTokenType::ADDITION,
                    str_starts_with($line, '-') => DiffTokenType::DELETION,
                    default => null,
                };
            }

            if (! $type instanceof DiffTokenType) {
                continue;
            }

            $tokens[] = new Token(
                offset: $match[1],
                value: $line,
                type: $type,
            );
        }

        $this->appendTokens($tokens, $pendingFileHeaders, DiffTokenType::DELETION);

        return $tokens;
    }

    private function isGitMetadata(string $line): bool
    {
        return preg_match(self::GIT_METADATA_PATTERN, $line) === 1;
    }

    /**
     * @return null|array{parentCount: int, sourceLines: ?int, targetLines: ?int}
     */
    private function parseHunkHeader(string $line): ?array
    {
        if (preg_match('/^(?<marker>@{2,})(?:\s|$)/', $line, $matches) !== 1) {
            return null;
        }

        $parentCount = strlen($matches['marker']) - 1;
        $sourceLines = null;
        $targetLines = null;

        if (
            $parentCount === 1
            && preg_match('/^@@ -\d+(?:,(?<source>\d+))? \+\d+(?:,(?<target>\d+))? @@(?:\s|$)/', $line, $ranges) === 1
        ) {
            $sourceLines = ($ranges['source'] ?? '') === '' ? 1 : (int) $ranges['source'];
            $targetLines = ($ranges['target'] ?? '') === '' ? 1 : (int) $ranges['target'];
        }

        return [
            'parentCount' => $parentCount,
            'sourceLines' => $sourceLines,
            'targetLines' => $targetLines,
        ];
    }

    private function classifyHunkLine(string $line, int $parentCount): ?DiffTokenType
    {
        $status = substr($line, 0, $parentCount);

        if (strlen($status) !== $parentCount || strspn($status, ' +-') !== $parentCount) {
            return null;
        }

        return match (true) {
            str_contains($status, '+') => DiffTokenType::ADDITION,
            str_contains($status, '-') => DiffTokenType::DELETION,
            default => DiffTokenType::CONTEXT,
        };
    }

    /**
     * @return array{?int, ?int}
     */
    private function consumeUnifiedLine(
        DiffTokenType $type,
        ?int $remainingSourceLines,
        ?int $remainingTargetLines,
    ): array {
        if ($remainingSourceLines === null || $remainingTargetLines === null) {
            return [$remainingSourceLines, $remainingTargetLines];
        }

        if ($type === DiffTokenType::CONTEXT || $type === DiffTokenType::DELETION) {
            $remainingSourceLines = max(0, $remainingSourceLines - 1);
        }

        if ($type === DiffTokenType::CONTEXT || $type === DiffTokenType::ADDITION) {
            $remainingTargetLines = max(0, $remainingTargetLines - 1);
        }

        return [$remainingSourceLines, $remainingTargetLines];
    }

    /**
     * @param Token[] $tokens
     * @param array<int, array{0: string, 1: int}> $lines
     */
    private function appendTokens(array &$tokens, array $lines, DiffTokenType $type): void
    {
        foreach ($lines as $line) {
            $tokens[] = new Token(
                offset: $line[1],
                value: $line[0],
                type: $type,
            );
        }
    }

    private function isOldFileHeader(string $line): bool
    {
        return preg_match('/^---(?:\s|$)/', $line) === 1;
    }

    private function isNewFileHeader(string $line): bool
    {
        return preg_match('/^\+\+\+(?:\s|$)/', $line) === 1;
    }

    private function isSpecialMarker(string $line): bool
    {
        return $line === '\\ No newline at end of file'
            || $line === 'GIT binary patch'
            || preg_match('/^(?:Binary files|Files) .+ differ$/', $line) === 1
            || preg_match('/^(?:literal|delta) \d+$/', $line) === 1;
    }
}
