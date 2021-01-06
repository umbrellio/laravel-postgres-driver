<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Definitions\Routines\Procedures;

use Illuminate\Support\Fluent;

/**
 * @method self in()
 * @method self inout()
 * @method self variadic()
 * @method self default()
 * @method self equal()
 * @method self expression()
 * @method CreateProcedureDefinition type(string $type)
 */
class ProcedureArgumentDefinition extends Fluent
{
}
