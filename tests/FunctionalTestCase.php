<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Tests;

use Illuminate\Support\Facades\DB;

abstract class FunctionalTestCase extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('database.default', 'main');
        $this->setConnectionConfig($app, 'main', TestUtil::getParamsForMainConnection());
    }

    protected function assertCommentOnColumn(string $table, string $column, ?string $expected = null): void
    {
        $comment = $this->getCommentListing($table, $column);

        if ($expected === null) {
            $this->assertNull($comment);
        }
        $this->assertSame($expected, $comment);
    }

    protected function assertDefaultOnColumn(string $table, string $column, ?string $expected = null): void
    {
        $defaultValue = $this->getDefaultListing($table, $column);

        if ($expected === null) {
            $this->assertNull($defaultValue);
        }
        $this->assertSame($expected, $defaultValue);
    }

    private function setConnectionConfig($app, $name, $params): void
    {
        $app['config']->set('database.connections.' . $name, [
            'driver' => 'pgsql',
            'host' => $params['host'],
            'port' => (int) $params['port'],
            'database' => $params['dbname'],
            'username' => $params['user'],
            'password' => $params['password'],
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
        ]);
    }

    private function getCommentListing(string $table, string $column)
    {
        $definition = DB::selectOne(
            '
                SELECT pgd.description FROM pg_catalog.pg_statio_all_tables AS st
                INNER JOIN pg_catalog.pg_description pgd ON (pgd.objoid = st.relid)
                INNER JOIN information_schema.columns c ON pgd.objsubid = c.ordinal_position AND c.table_schema = st.schemaname AND c.table_name = st.relname
                WHERE c.table_name = ? AND c.column_name = ?
            ',
            [$table, $column]
        );

        return $definition ? $definition->description : null;
    }

    private function getDefaultListing(string $table, string $column)
    {
        $definition = DB::selectOne(
            'SELECT column_default FROM information_schema.columns WHERE table_name = ? and column_name = ?',
            [$table, $column]
        );

        return $definition ? $definition->column_default : null;
    }
}
