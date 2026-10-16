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

    public const array SPECIAL_FORMS = [
        'define', 'def', 'define-values', ...self::FUNCTION_DEFINITION_FORMS,
        'lambda', 'fn', 'let', 'let*', 'letrec', 'let-values', 'let*-values', 'if', 'if-let', 'when', 'when-let',
        'unless', 'cond', 'case', 'match', 'match*', 'else', 'begin', 'do', 'progn', 'and', 'or', 'set!', 'quote',
        'quasiquote', 'unquote', 'unquote-splicing', 'try', 'catch', 'throw', 'import', 'export', 'module', 'load',
        'eval', 'macroexpand', 'while', 'dotimes', 'for-range', 'guard', 'parameterize', 'delay', 'force', 'async',
        'await', 'prompt', 'message', 'with-retry', 'with-session', 'with-span', 'with-stream', 'with-open',
        'policy/without', 'io/with-raw-mode', 'term/with-alt-screen', 'term/with-mouse',
        'term/with-bracketed-paste', 'term/with-focus-events', 'term/with-kitty-keys', '->', '->>', 'as->', 'some->',
    ];

    public const array PRELUDE_MACROS = [
        'approval', 'async/map', 'async/pool-map', 'async/spawn-all', 'checkpoint', 'parallel', 'parallel-settled',
        'phase', 'pipeline', 'pipeline-settled', 'settled-partition', 'settled/err?', 'settled/ok?', 'step',
        'workflow/run-form', 'ws/listen',
    ];

    public const array OPERATORS = ['+', '-', '*', '/', '%', '=', '>', '<', '>=', '<=', 'eq?', 'equal?', 'eqv?'];

    public const string SYMBOL_CHARACTERS = '\p{L}\p{N}_+\-*\/!?<>=&%^~.#';

    public const string SYMBOL_START = '[\p{L}+\-*\/!?<>=_&%^~.]';

    public const string SYMBOL = '[' . self::SYMBOL_CHARACTERS . ']';

    public const string SYMBOL_END = '(?![' . self::SYMBOL_CHARACTERS . '])';

    public const string PLAIN_STRING = '"(?:[^"\\\\]++|\\\\.)*+"';

    public const string OPEN_STRING = '"(?:[^"\\\\]++|\\\\.)*+(?:"|\\\\?\z)';

    private const string INTERPOLATION = '\{(?:[^{}"\\\\]++|\\\\.|' . self::PLAIN_STRING . ')*+\}';

    private const string NESTED_INTERPOLATION = '\{(?:[^{}"\\\\]++|\\\\.|' . self::PLAIN_STRING . '|' . self::INTERPOLATION . ')*+\}';

    private const string DEEP_INTERPOLATION = '\{(?:[^{}"\\\\]++|\\\\.|' . self::PLAIN_STRING . '|' . self::NESTED_INTERPOLATION . ')*+\}';

    public const string STRING = '(?<![' . self::SYMBOL_CHARACTERS . '])f"(?:[^"\\\\$]++|\\\\.|\$(?!\{)|\$' . self::DEEP_INTERPOLATION . ')*+(?:"|\\\\?\z)'
        . '|#' . self::OPEN_STRING . '|' . self::OPEN_STRING;

    public const string CHARACTER = '#\\\\.';

    public const string ATOM_START = '(?<![^\s(\[{\'`,@])';

    public const string NUMBER_END = '(?![^\s()\[\]{}";\'`,#])';

    public static function head(string $alternatives): string
    {
        return '/(?<=\()(?<match>(?:' . $alternatives . '))' . self::SYMBOL_END . '/u';
    }

    public static function atom(string $alternatives, string $end = self::SYMBOL_END): string
    {
        return '/' . self::ATOM_START . '(?<match>(?:' . $alternatives . '))' . $end . '/u';
    }

    /**
     * @param string[] $words
     */
    public static function alternatives(array $words): string
    {
        return implode('|', array_map(static fn (string $word): string => preg_quote($word, '/'), $words));
    }
}
