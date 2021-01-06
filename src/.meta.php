<?php

namespace Illuminate\Database\Schema {

    use Illuminate\Support\Fluent;
    use Umbrellio\Postgres\Schema\Definitions\Tables\AttachPartitionDefinition;
    use Umbrellio\Postgres\Schema\Definitions\Indexes\CheckDefinition;
    use Umbrellio\Postgres\Schema\Definitions\Indexes\ExcludeDefinition;
    use Umbrellio\Postgres\Schema\Definitions\Routines\Functions\CreateFunctionDefinition;
    use Umbrellio\Postgres\Schema\Definitions\Routines\Procedures\CreateProcedureDefinition;
    use Umbrellio\Postgres\Schema\Definitions\Tables\LikeDefinition;
    use Umbrellio\Postgres\Schema\Definitions\Routines\Triggers\CreateTriggerDefinition;
    use Umbrellio\Postgres\Schema\Definitions\Views\ViewDefinition;
    use Umbrellio\Postgres\Schema\Definitions\Indexes\UniqueDefinition;

    /**
     * @method AttachPartitionDefinition attachPartition(string $partition)
     * @method void detachPartition(string $partition)
     * @method LikeDefinition like(string $table)
     * @method Fluent ifNotExists()
     * @method UniqueDefinition uniquePartial($columns, ?string $index = null, ?string $algorithm = null)
     * @method ViewDefinition createView(string $view, string $select, bool $materialize = false)
     * @method Fluent dropView(string $view)
     * @method ColumnDefinition numeric(string $column, ?int $precision = null, ?int $scale = null)
     * @method ColumnDefinition tsrange(string $column)
     * @method ExcludeDefinition exclude($columns, ?string $index = null)
     * @method CheckDefinition check($columns, ?string $index = null)
     * @method CreateFunctionDefinition createFunction(string $name)
     * @method CreateProcedureDefinition createProcedure(string $name)
     * @method CreateTriggerDefinition createTrigger(string $name)
     * @method Fluent dropProcedure(string $name)
     * @method Fluent dropFunction(string $name)
     * @method Fluent dropTrigger(string $name, bool $dropDepends = false)
     */
    class Blueprint
    {
    }

    /**
     * @method ColumnDefinition using($expression)
     */
    class ColumnDefinition
    {
    }
}
