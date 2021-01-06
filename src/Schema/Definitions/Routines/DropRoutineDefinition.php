<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Definitions\Routines;

use Illuminate\Support\Fluent;

/**
 * @method self name(string $name)
 * @method DropRoutineArgumentDefinition arg(?string $name = null)
 * @method self ifExists()
 * @method self cascade()
 * @method self restrict()
 */
class DropRoutineDefinition extends Fluent
{
}
