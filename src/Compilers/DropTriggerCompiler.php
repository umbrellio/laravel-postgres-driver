<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Compilers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\Grammar;
use Umbrellio\Postgres\Schema\Builders\Routines\DropTriggerBuilder;

class DropTriggerCompiler
{
    public static function compile(Grammar $grammar, Blueprint $blueprint, DropTriggerBuilder $command): array
    {
        return [];
    }
}
