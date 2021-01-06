<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Definitions\Routines\Functions;

use Illuminate\Support\Fluent;

/**
 * @method CreateFunctionDefinition immutable()
 * @method CreateFunctionDefinition stable()
 * @method CreateFunctionDefinition volatile()
 * @method CreateFunctionDefinition leakProof(?bool $not = null)
 */
class StabilityDefinition extends Fluent
{
}
