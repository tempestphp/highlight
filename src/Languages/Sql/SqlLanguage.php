<?php

declare(strict_types=1);

namespace Tempest\Highlight\Languages\Sql;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Php\Patterns\KeywordPattern;
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
    public function getName(): string
    {
        return 'sql';
    }

    public function getInjections(): array
    {
        return [
            ...parent::getInjections(),
        ];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),

            // KEYWORDS
            (new KeywordPattern('ADD'))->caseInsensitive(),
            (new KeywordPattern('ADD CONSTRAINT'))->caseInsensitive(),
            (new KeywordPattern('ALL'))->caseInsensitive(),
            (new KeywordPattern('ALTER'))->caseInsensitive(),
            (new KeywordPattern('ALTER COLUMN'))->caseInsensitive(),
            (new KeywordPattern('ALTER TABLE'))->caseInsensitive(),
            (new KeywordPattern('AND'))->caseInsensitive(),
            (new KeywordPattern('ANY'))->caseInsensitive(),
            (new KeywordPattern('AS'))->caseInsensitive(),
            (new KeywordPattern('ASC'))->caseInsensitive(),
            (new KeywordPattern('BACKUP DATABASE'))->caseInsensitive(),
            (new KeywordPattern('BETWEEN'))->caseInsensitive(),
            (new KeywordPattern('CASE'))->caseInsensitive(),
            (new KeywordPattern('CAST'))->caseInsensitive(),
            (new KeywordPattern('CHECK'))->caseInsensitive(),
            (new KeywordPattern('COLUMN'))->caseInsensitive(),
            (new KeywordPattern('CONSTRAINT'))->caseInsensitive(),
            (new KeywordPattern('CREATE'))->caseInsensitive(),
            (new KeywordPattern('CREATE DATABASE'))->caseInsensitive(),
            (new KeywordPattern('CREATE INDEX'))->caseInsensitive(),
            (new KeywordPattern('CREATE OR REPLACE VIEW'))->caseInsensitive(),
            (new KeywordPattern('CREATE TABLE'))->caseInsensitive(),
            (new KeywordPattern('CREATE PROCEDURE'))->caseInsensitive(),
            (new KeywordPattern('CREATE UNIQUE INDEX'))->caseInsensitive(),
            (new KeywordPattern('CREATE VIEW'))->caseInsensitive(),
            (new KeywordPattern('DATABASE'))->caseInsensitive(),
            (new KeywordPattern('DEFAULT'))->caseInsensitive(),
            (new KeywordPattern('DELETE'))->caseInsensitive(),
            (new KeywordPattern('DESC'))->caseInsensitive(),
            (new KeywordPattern('DISTINCT'))->caseInsensitive(),
            (new KeywordPattern('DROP'))->caseInsensitive(),
            (new KeywordPattern('DROP COLUMN'))->caseInsensitive(),
            (new KeywordPattern('DROP CONSTRAINT'))->caseInsensitive(),
            (new KeywordPattern('DROP DATABASE'))->caseInsensitive(),
            (new KeywordPattern('DROP DEFAULT'))->caseInsensitive(),
            (new KeywordPattern('DROP INDEX'))->caseInsensitive(),
            (new KeywordPattern('DROP TABLE'))->caseInsensitive(),
            (new KeywordPattern('DROP VIEW'))->caseInsensitive(),
            (new KeywordPattern('ELSE'))->caseInsensitive(),
            (new KeywordPattern('END'))->caseInsensitive(),
            (new KeywordPattern('EXCEPT'))->caseInsensitive(),
            (new KeywordPattern('EXEC'))->caseInsensitive(),
            (new KeywordPattern('EXISTS'))->caseInsensitive(),
            (new KeywordPattern('FOREIGN KEY'))->caseInsensitive(),
            (new KeywordPattern('FROM'))->caseInsensitive(),
            (new KeywordPattern('FULL JOIN'))->caseInsensitive(),
            (new KeywordPattern('FULL OUTER JOIN'))->caseInsensitive(),
            (new KeywordPattern('GROUP BY'))->caseInsensitive(),
            (new KeywordPattern('HAVING'))->caseInsensitive(),
            (new KeywordPattern('IN'))->caseInsensitive(),
            (new KeywordPattern('INDEX'))->caseInsensitive(),
            (new KeywordPattern('INNER JOIN'))->caseInsensitive(),
            (new KeywordPattern('INSERT INTO'))->caseInsensitive(),
            (new KeywordPattern('INSERT INTO SELECT'))->caseInsensitive(),
            (new KeywordPattern('INTERSECT'))->caseInsensitive(),
            (new KeywordPattern('IS NULL'))->caseInsensitive(),
            (new KeywordPattern('IS NOT NULL'))->caseInsensitive(),
            (new KeywordPattern('JOIN'))->caseInsensitive(),
            (new KeywordPattern('LEFT JOIN'))->caseInsensitive(),
            (new KeywordPattern('LIKE'))->caseInsensitive(),
            (new KeywordPattern('LIMIT'))->caseInsensitive(),
            (new KeywordPattern('NOT'))->caseInsensitive(),
            (new KeywordPattern('NOT NULL'))->caseInsensitive(),
            (new KeywordPattern('OFFSET'))->caseInsensitive(),
            (new KeywordPattern('OR'))->caseInsensitive(),
            (new KeywordPattern('ORDER BY'))->caseInsensitive(),
            (new KeywordPattern('OUTER JOIN'))->caseInsensitive(),
            (new KeywordPattern('PRIMARY KEY'))->caseInsensitive(),
            (new KeywordPattern('PROCEDURE'))->caseInsensitive(),
            (new KeywordPattern('RIGHT JOIN'))->caseInsensitive(),
            (new KeywordPattern('ROWNUM'))->caseInsensitive(),
            (new KeywordPattern('SELECT'))->caseInsensitive(),
            (new KeywordPattern('SELECT DISTINCT'))->caseInsensitive(),
            (new KeywordPattern('SELECT INTO'))->caseInsensitive(),
            (new KeywordPattern('SELECT TOP'))->caseInsensitive(),
            (new KeywordPattern('SET'))->caseInsensitive(),
            (new KeywordPattern('SOME'))->caseInsensitive(),
            (new KeywordPattern('TABLE'))->caseInsensitive(),
            (new KeywordPattern('THEN'))->caseInsensitive(),
            (new KeywordPattern('TOP'))->caseInsensitive(),
            (new KeywordPattern('TRUNCATE TABLE'))->caseInsensitive(),
            (new KeywordPattern('UNION'))->caseInsensitive(),
            (new KeywordPattern('UNION ALL'))->caseInsensitive(),
            (new KeywordPattern('UNIQUE'))->caseInsensitive(),
            (new KeywordPattern('UPDATE'))->caseInsensitive(),
            (new KeywordPattern('VALUES'))->caseInsensitive(),
            (new KeywordPattern('VIEW'))->caseInsensitive(),
            (new KeywordPattern('WHEN'))->caseInsensitive(),
            (new KeywordPattern('WHERE'))->caseInsensitive(),
            (new KeywordPattern('ON'))->caseInsensitive(),

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
