<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Definitions\Routines\Triggers;

use Illuminate\Support\Fluent;

/**
 * @method CreateTriggerDefinition immediate()
 * @method CreateTriggerDefinition deferred()
 */
class DeferrableDefinition extends Fluent
{
}
