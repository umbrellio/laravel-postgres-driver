<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Builders\Routines\Functions;

use Illuminate\Support\Fluent;
use Umbrellio\Postgres\Schema\Builders\Routines\CreateFunctionBuilder;

class ParallelBuilder extends Fluent
{
    private $builder;

    public function __construct(CreateFunctionBuilder $builder, $attributes = [])
    {
        $this->builder = $builder;

        parent::__construct($attributes);
    }

    public function __call($method, $parameters)
    {
        parent::__call($method, $parameters);

        return $this->builder;
    }
}
