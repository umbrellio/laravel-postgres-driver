<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Definitions\Routines\Triggers;

use Illuminate\Support\Fluent;

/**
 * @method self name(string $name)
 * @method self on(string $tableName)
 * @method self ifExists()
 * @method self cascade()
 * @method self restrict()
 */
class DropTriggerDefinition extends Fluent
{
}
