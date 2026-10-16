<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sema;

final class SemaSyntax
{
    public const array FUNCTION_DEFINITION_FORMS = [
        'defn', 'defun', 'defmacro', 'define-syntax', 'define-record-type', 'defagent', 'deftool', 'defworkflow',
        'defpolicy', 'defmulti', 'defmethod',
    ];

    public const array VARIABLE_DEFINITION_FORMS = ['define', 'def', 'set!'];

    public const array DEFINITION_FORMS = [
        'define', 'def', 'define-values', ...self::FUNCTION_DEFINITION_FORMS,
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

    public const array PRELUDE_MACROS = [
        'approval', 'async/map', 'async/pool-map', 'async/spawn-all', 'checkpoint', 'parallel', 'parallel-settled',
        'phase', 'pipeline', 'pipeline-settled', 'settled-partition', 'settled/err?', 'settled/ok?', 'step',
        'workflow/run-form', 'ws/listen',
    ];

    public const array OPERATORS = ['+', '-', '*', '/', '%', '=', '>', '<', '>=', '<=', 'eq?', 'equal?', 'eqv?'];

    public const string SYMBOL_START = '[\p{L}+\-*\/!?<>=_&%^~.]';

    public const string SYMBOL = '[\p{L}\p{N}_+\-*\/!?<>=&%^~.#]';

    public const string STRING = '"(?:[^"\\\\]|\\\\.)*"|#"(?:[^"\\\\]|\\\\.)*"'
        . '|(?<![\p{L}\p{N}_])f"(?:[^"\\\\$]|\\\\.|\$(?!\{)|\$(?<interpolation>\{(?:[^{}"\\\\]|\\\\.|"(?:[^"\\\\]|\\\\.)*"|(?&interpolation))*\}))*"';

    public const string CHARACTER = '#\\\\.';

    public const string ATOM_START = '(?<![^\s(\[{\'`,@])';

    public const string ATOM_END = '(?![^\s()\[\]{}";\'`,])';

    public static function head(string $alternatives): string
    {
        return '/(?<=\()(?<match>(?:' . $alternatives . '))' . self::ATOM_END . '/u';
    }

    public static function atom(string $alternatives): string
    {
        return '/' . self::ATOM_START . '(?<match>(?:' . $alternatives . '))' . self::ATOM_END . '/u';
    }

    public static function alternatives(array $words): string
    {
        return implode('|', array_map(fn (string $word): string => preg_quote($word, '/'), $words));
    }
}
