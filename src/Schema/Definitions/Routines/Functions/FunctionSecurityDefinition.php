<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Definitions\Routines\Functions;

use Illuminate\Support\Fluent;

/**
 * @method CreateFunctionDefinition invoker(?bool $external = null)
 * @method CreateFunctionDefinition definer(?bool $external = null)
 */
class FunctionSecurityDefinition extends Fluent
{
}
