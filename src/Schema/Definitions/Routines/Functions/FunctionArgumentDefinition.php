<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Definitions\Routines\Functions;

use Illuminate\Support\Fluent;

/**
 * @method self in()
 * @method self out()
 * @method self inout()
 * @method self variadic()
 * @method self default(mixed $value)
 * @method self equal()
 * @method self defaultExpression(mixed $expression)
 * @method self type(string $type)
 */
class FunctionArgumentDefinition extends Fluent
{
}
