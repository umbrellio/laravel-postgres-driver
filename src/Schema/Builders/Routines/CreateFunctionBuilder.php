<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Builders\Routines;

use Illuminate\Support\Fluent;
use Umbrellio\Postgres\Schema\Builders\Routines\Functions\ExecutionBuilder;
use Umbrellio\Postgres\Schema\Builders\Routines\Functions\FunctionArgumentBuilder;
use Umbrellio\Postgres\Schema\Builders\Routines\Functions\FunctionSecurityBuilder;
use Umbrellio\Postgres\Schema\Builders\Routines\Functions\FunctionSetBuilder;
use Umbrellio\Postgres\Schema\Builders\Routines\Functions\ParallelBuilder;
use Umbrellio\Postgres\Schema\Builders\Routines\Functions\StabilityBuilder;

class CreateFunctionBuilder extends Fluent
{
    public function __call($method, $parameters)
    {
        switch ($method) {
            case 'arg':
                $command = new FunctionArgumentBuilder($this);
                $this->attributes[$method] = call_user_func_array([$command, $method], $parameters);
                break;
            case 'stability':
                $command = new StabilityBuilder($this);
                $this->attributes[$method] = call_user_func_array([$command, $method], $parameters);
                break;
            case 'execution':
                $command = new ExecutionBuilder($this);
                break;
            case 'security':
                $command = new FunctionSecurityBuilder($this);
                break;
            case 'set':
                $command = new FunctionSetBuilder($this);
                break;
            case 'parallel':
                $command = new ParallelBuilder($this);
                break;
            default:
                $command = $this;
        }

        parent::__call($method, $parameters);

        return $command ?? $this;
    }
}
