<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Definitions\Routines\Procedures;

use Illuminate\Support\Fluent;

/**
 * @method CreateProcedureDefinition invoker(?bool $external = null)
 * @method CreateProcedureDefinition definer(?bool $external = null)
 */
class ProcedureSecurityDefinition extends Fluent
{
}
