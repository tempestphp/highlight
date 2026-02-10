<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sql;

use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Php\Patterns\CombinedKeywordPattern;
use Tempest\Highlight\Languages\Sql\Patterns\SqlAsTablePattern;
use Tempest\Highlight\Languages\Sql\Patterns\SqlDoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Sql\Patterns\SqlFromTablePattern;
use Tempest\Highlight\Languages\Sql\Patterns\SqlFunctionPattern;
use Tempest\Highlight\Languages\Sql\Patterns\SqlJoinTablePattern;
use Tempest\Highlight\Languages\Sql\Patterns\SqlMultilineCommentPattern;
use Tempest\Highlight\Languages\Sql\Patterns\SqlPropertyPattern;
use Tempest\Highlight\Languages\Sql\Patterns\SqlSinglelineCommentPattern;
use Tempest\Highlight\Languages\Sql\Patterns\SqlSingleQuoteValuePattern;
use Tempest\Highlight\Languages\Sql\Patterns\SqlTableAccessPattern;
use Tempest\Highlight\Languages\Sql\Patterns\SqlTablePropertyPattern;

class SqlLanguage extends BaseLanguage
{
    private const array KEYWORDS = [
        'ADD', 'ADD CONSTRAINT', 'ALL', 'ALTER', 'ALTER COLUMN',
        'ALTER TABLE', 'AND', 'ANY', 'AS', 'ASC', 'BACKUP DATABASE',
        'BETWEEN', 'CASE', 'CAST', 'CHECK', 'COLUMN', 'CONSTRAINT',
        'CREATE', 'CREATE DATABASE', 'CREATE INDEX',
        'CREATE OR REPLACE VIEW', 'CREATE TABLE', 'CREATE PROCEDURE',
        'CREATE UNIQUE INDEX', 'CREATE VIEW', 'DATABASE', 'DEFAULT',
        'DELETE', 'DESC', 'DISTINCT', 'DROP', 'DROP COLUMN',
        'DROP CONSTRAINT', 'DROP DATABASE', 'DROP DEFAULT',
        'DROP INDEX', 'DROP TABLE', 'DROP VIEW', 'ELSE', 'END',
        'EXCEPT', 'EXEC', 'EXISTS', 'FOREIGN KEY', 'FROM',
        'FULL JOIN', 'FULL OUTER JOIN', 'GROUP BY', 'HAVING', 'IN',
        'INDEX', 'INNER JOIN', 'INSERT INTO', 'INSERT INTO SELECT',
        'INTERSECT', 'IS NULL', 'IS NOT NULL', 'JOIN', 'LEFT JOIN',
        'LIKE', 'LIMIT', 'NOT', 'NOT NULL', 'OFFSET', 'OR',
        'ORDER BY', 'OUTER JOIN', 'PRIMARY KEY', 'PROCEDURE',
        'RIGHT JOIN', 'ROWNUM', 'SELECT', 'SELECT DISTINCT',
        'SELECT INTO', 'SELECT TOP', 'SET', 'SOME', 'TABLE', 'THEN',
        'TOP', 'TRUNCATE TABLE', 'UNION', 'UNION ALL', 'UNIQUE',
        'UPDATE', 'VALUES', 'VIEW', 'WHEN', 'WHERE', 'ON',
    ];

    public function getName(): string
    {
        return 'sql';
    }

    #[Override]
    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
        ];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            // KEYWORDS
            new CombinedKeywordPattern(self::KEYWORDS, caseInsensitive: true),

            // COMMENTS
            new SqlMultilineCommentPattern(),
            new SqlSinglelineCommentPattern(),

            // TYPES
            new SqlTableAccessPattern(),
            new SqlFromTablePattern(),
            new SqlJoinTablePattern(),
            new SqlAsTablePattern(),

            // VALUES
            new SqlSingleQuoteValuePattern(),
            new SqlDoubleQuoteValuePattern(),

            // PROPERTIES
            new SqlFunctionPattern(),
            new SqlTablePropertyPattern(),
            new SqlPropertyPattern(),
        ];
    }
}
