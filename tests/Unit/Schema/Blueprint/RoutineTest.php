<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Unit\Schema\Blueprint;

use Umbrellio\Postgres\Tests\TestCase;
use Umbrellio\Postgres\Tests\Unit\Helpers\BlueprintAssertions;

class RoutineTest extends TestCase
{
    use BlueprintAssertions;

    private const TABLE = 'test_table';

    protected function setUp(): void
    {
        parent::setUp();

        $this->initializeMock(static::TABLE);
    }

    /**
     * @test
     */
    public function createFunction(): void
    {
        $this->blueprint->createFunction('test_function');
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function createProcedure(): void
    {
        $this->blueprint->createProcedure('test_procedure');
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function createTrigger(): void
    {
        $this->blueprint->createTrigger('test_trigger');
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function dropFunction(): void
    {
        $this->blueprint->dropFunction('test_function');
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function dropProcedure(): void
    {
        $this->blueprint->dropProcedure('test_procedure');
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function dropTrigger(): void
    {
        $this->blueprint->dropTrigger('test_trigger');
        $this->assertTrue(true);
    }
}
