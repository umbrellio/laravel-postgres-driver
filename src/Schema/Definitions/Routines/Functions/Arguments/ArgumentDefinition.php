<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Definitions\Routines\Functions\Arguments;

use Illuminate\Support\Fluent;
use Umbrellio\Postgres\Schema\Definitions\Routines\Functions\FunctionArgumentDefinition;

/**
 * @method FunctionArgumentDefinition in()
 * @method FunctionArgumentDefinition out()
 * @method FunctionArgumentDefinition inout()
 * @method FunctionArgumentDefinition variadic()
 */
class ArgumentDefinition extends Fluent
{
}
