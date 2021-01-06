<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Definitions\Routines\Procedures;

use Illuminate\Support\Fluent;
use Umbrellio\Postgres\Schema\Definitions\Routines\RoutineDefinition;

/**
 * @mixin RoutineDefinition
 *
 * @method ProcedureArgumentDefinition arg(?string $name = null)
 * @method ProcedureSetDefinition set(string $configurationParameter)
 * @method ProcedureSecurityDefinition security()
 */
class CreateProcedureDefinition extends Fluent
{
}
