<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Compilers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\Grammar;
use Umbrellio\Postgres\Schema\Builders\Routines\CreateTriggerBuilder;

class CreateTriggerCompiler
{
    public static function compile(Grammar $grammar, Blueprint $blueprint, CreateTriggerBuilder $command): array
    {
        return [];
    }
}
