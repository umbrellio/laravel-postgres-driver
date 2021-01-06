<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Definitions\Routines\Triggers;

use Illuminate\Support\Fluent;

/**
 * @method self constraint(bool $value = true)
 * @method self name(string $triggerName)
 * @method EventPointDefinition eventPoint()
 * @method EventDefinition event()
 * @method self on(string $tableName)
 * @method self from(string $referencedTableName)
 * @method self notDeferrable()
 * @method DeferrableDefinition deferrable()
 * @method ReferencingDefinition referencing()
 * @method ForDefinition for(bool $each = false)
 * @method self when(string $condition)
 * @method ExecuteDefinition execute(string $routine)
 */
class CreateTriggerDefinition extends Fluent
{
}
