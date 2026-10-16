<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema;

final class SemaSyntax
{
    public const array DEFINITION_FORMS = [
        'define', 'def', 'defn', 'defun', 'defmacro', 'define-syntax', 'define-values', 'define-record-type',
        'defagent', 'deftool', 'defworkflow', 'defpolicy', 'defmulti', 'defmethod',
    ];

    public const array SPECIAL_FORMS = [
        ...self::DEFINITION_FORMS,
        'lambda', 'fn', 'let', 'let*', 'letrec', 'let-values', 'let*-values', 'if', 'if-let', 'when', 'when-let',
        'unless', 'cond', 'case', 'match', 'match*', 'else', 'begin', 'do', 'progn', 'and', 'or', 'set!', 'quote',
        'quasiquote', 'unquote', 'unquote-splicing', 'try', 'catch', 'throw', 'import', 'export', 'module', 'load',
        'eval', 'macroexpand', 'while', 'dotimes', 'for-range', 'guard', 'parameterize', 'delay', 'force', 'async',
        'await', 'prompt', 'message', 'with-retry', 'with-session', 'with-span', 'with-stream', 'with-open',
        'llm/with-budget', 'policy/without', 'io/with-raw-mode', 'term/with-alt-screen', 'term/with-mouse',
        'term/with-bracketed-paste', 'term/with-focus-events', 'term/with-kitty-keys', '->', '->>', 'as->', 'some->',
    ];

    public const string SYMBOL = '[\p{L}\p{N}_+\-*\/!?<>=&%^~.#]';

    public const string STRING = '"(?:[^"\\\\]|\\\\.)*"|#"(?:[^"\\\\]|\\\\.)*"'
        . '|(?<![\p{L}\p{N}_])f"(?:[^"\\\\$]|\\\\.|\$(?!\{)|\$(?<interpolation>\{(?:[^{}"\\\\]|\\\\.|"(?:[^"\\\\]|\\\\.)*"|(?&interpolation))*\}))*"';

    public const string CHARACTER = '#\\\\.';

    public const string ATOM_START = '(?<![^\s(\[{\'`,@])';

    public const string ATOM_END = '(?![^\s()\[\]{}";\'`,])';

    public static function atom(string $alternatives): string
    {
        return '/' . self::ATOM_START . '(?<match>(?:' . $alternatives . '))' . self::ATOM_END . '/u';
    }

    public static function alternatives(array $words): string
    {
        return implode('|', array_map(fn (string $word): string => preg_quote($word, '/'), $words));
    }
}
