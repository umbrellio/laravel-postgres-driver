<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Helpers;

use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\TestCase;

/**
 * @static void assertNotNull($actual, string $message = '')
 * @static void assertSame($expected, $actual, string $message = '')
 * @static void assertNull($actual, string $message = '')
 * @static void assertMatchesRegularExpression(string $pattern, string $string, string $message = '')
 * @static void assertTrue($condition, string $message = '')
 * @static void assertFalse($condition, string $message = '')
 *
 * @see Assert
 */
trait IndexAssertions
{
    protected function seeIndex(string $index): void
    {
        $this->assertNotNull($this->getIndexListing($index));
    }

    protected function notSeeIndex(string $index): void
    {
        $this->assertNull($this->getIndexListing($index));
    }

    protected function assertSameIndex(string $index, string $expectedDef): void
    {
        $definition = $this->getIndexListing($index);

        $this->seeIndex($index);
        $this->assertSame($expectedDef, $definition);
    }

    protected function assertRegExpIndex(string $index, string $expectedDef): void
    {
        $definition = $this->getIndexListing($index);

        $this->seeIndex($index);
        $this->assertMatchesRegularExpression($expectedDef, $definition);
    }

    protected function dontSeeConstraint(string $table, string $index): void
    {
        $this->assertFalse($this->existConstraintOnTable($table, $index));
    }

    protected function seeConstraint(string $table, string $index): void
    {
        $this->assertTrue($this->existConstraintOnTable($table, $index));
    }

    private function getIndexListing($index): ?string
    {
        $definition = DB::selectOne('SELECT * FROM pg_indexes WHERE indexname = ?', [$index]);

        return $definition ? $definition->indexdef : null;
    }

    private function existConstraintOnTable(string $table, string $index): bool
    {
        $expression = '
            SELECT c.conname
            FROM pg_constraint c
            LEFT JOIN pg_class t ON c.conrelid  = t.oid
            LEFT JOIN pg_class t2 ON c.confrelid = t2.oid
            WHERE t.relname = ? AND c.conname = ?;
        ';
        $definition = DB::selectOne($expression, [$table, $index]);
        return $definition ? true : false;
    }
}
