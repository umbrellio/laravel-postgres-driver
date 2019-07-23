<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Tests\Functional\Schema;

use Generator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Umbrellio\Postgres\Schema\Blueprint;
use Umbrellio\Postgres\Tests\FunctionalTestCase;

class CreateIndexTest extends FunctionalTestCase
{
    use DatabaseTransactions;

    /** @test */
    public function createGistIndex(): void
    {
        Schema::create('test_table', function (Blueprint $table) {
            $table->tsRange('code')->gist();
        });

        $this->seeIndex('test_table_code_gist');

        Schema::table('test_table', function (Blueprint $table) {
            $table->tsRange('some_id');
            $table->tsRange('some_key');
            $table->gist('some_key', 'specify_gist_key');
            $table->gist('some_id');
        });

        $this->seeIndex('specify_gist_key');
        $this->seeIndex('test_table_some_id_gist');
    }

    /** @test */
    public function createGinIndex(): void
    {
        Schema::create('test_table', function (Blueprint $table) {
            $table->tsVector('id')->gin();
        });

        $this->seeIndex('test_table_id_gin');

        Schema::table('test_table', function (Blueprint $table) {
            $table->tsVector('some_id');
            $table->tsVector('some_key');
            $table->gin('some_key', 'specify_gin_key');
            $table->gin('some_id');
        });

        $this->seeIndex('specify_gin_key');
        $this->seeIndex('test_table_some_id_gin');
    }

    /** @test */
    public function createIndexIfNotExists(): void
    {
        Schema::create('test_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            if (!$table->hasIndex(['name'], true)) {
                $table->unique(['name']);
            }
        });

        $this->assertTrue(Schema::hasTable('test_table'));

        Schema::table('test_table', function (Blueprint $table) {
            if (!$table->hasIndex(['name'], true)) {
                $table->unique(['name']);
            }
        });

        $this->seeIndex('test_table_name_unique');
    }

    /**
     * @test
     * @dataProvider provideIndexes
     */
    public function createPartialUniqueWithNull($expected, $callback): void
    {
        Schema::create('test_table', function (Blueprint $table) use ($callback) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->integer('phone');
            $table->boolean('enabled');
            $table->integer('icq');
            $table->softDeletes();
            $callback($table);
        });

        $this->assertTrue(Schema::hasTable('test_table'));
        $this->assertRegExpIndex('test_table_name_unique', '/' . $this->getDummyIndex() . $expected . '/');
    }

    /** @test */
    public function createSpecifyIndex(): void
    {
        Schema::create('test_table', function (Blueprint $table) {
            $table->string('name')->index('specify_index_name');
        });

        $this->assertTrue(Schema::hasTable('test_table'));

        $this->assertRegExpIndex(
            'specify_index_name',
            '/CREATE INDEX specify_index_name ON (public.)?test_table USING btree \(name\)/'
        );
    }

    public function provideIndexes(): Generator
    {
        yield ['', function (Blueprint $table) {
            $table->uniquePartial('name');
        }];
        yield [
            ' WHERE \(deleted_at IS NULL\)',
            function (Blueprint $table) {
                $table->uniquePartial('name')->whereNull('deleted_at');
            },
        ];
        yield [
            ' WHERE \(deleted_at IS NOT NULL\)',
            function (Blueprint $table) {
                $table->uniquePartial('name')->whereNotNull('deleted_at');
            },
        ];
        yield [
            ' WHERE \(phone = 1234\)',
            function (Blueprint $table) {
                $table->uniquePartial('name')->where('phone', '=', 1234);
            },
        ];
        yield [
            " WHERE \(\(code\)::text = 'test'::text\)",
            function (Blueprint $table) {
                $table->uniquePartial('name')->where('code', '=', 'test');
            },
        ];
        yield [
            ' WHERE \(\(phone >= 1\) AND \(phone <= 2\)\)',
            function (Blueprint $table) {
                $table->uniquePartial('name')->whereBetween('phone', [1, 2]);
            },
        ];
        yield [
            ' WHERE \(\(phone < 1\) OR \(phone > 2\)\)',
            function (Blueprint $table) {
                $table->uniquePartial('name')->whereNotBetween('phone', [1, 2]);
            },
        ];
        yield [
            ' WHERE \(phone <> icq\)',
            function (Blueprint $table) {
                $table->uniquePartial('name')->whereColumn('phone', '<>', 'icq');
            },
        ];
        yield [
            ' WHERE \(\(phone = 1\) AND \(icq < 2\)\)',
            function (Blueprint $table) {
                $table->uniquePartial('name')->whereRaw('phone = ? and icq < ?', [1, 2]);
            },
        ];
        yield [
            ' WHERE \(phone = ANY \(ARRAY\[1, 2, 4\]\)\)',
            function (Blueprint $table) {
                $table->uniquePartial('name')->whereIn('phone', [1, 2, 4]);
            },
        ];
        yield [
            ' WHERE \(0 = 1\)',
            function (Blueprint $table) {
                $table->uniquePartial('name')->whereIn('phone', []);
            },
        ];
        yield [
            ' WHERE \(phone <> ALL \(ARRAY\[1, 2, 4\]\)\)',
            function (Blueprint $table) {
                $table->uniquePartial('name')->whereNotIn('phone', [1, 2, 4]);
            },
        ];
        yield [
            ' WHERE \(1 = 1\)',
            function (Blueprint $table) {
                $table->uniquePartial('name')->whereNotIn('phone', []);
            },
        ];
    }

    protected function getDummyIndex()
    {
        return 'CREATE UNIQUE INDEX test_table_name_unique ON (public.)?test_table USING btree \(name\)';
    }
}
