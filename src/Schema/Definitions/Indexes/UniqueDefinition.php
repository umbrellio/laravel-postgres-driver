<?php

declare(strict_types=1);

namespace Umbrellio\Postgres\Schema\Definitions\Indexes;

use Illuminate\Support\Fluent;

/**
 * @method self where($column, $operator, $value, $boolean = 'and')
 * @method self whereRaw($sql, $bindings = [], $boolean = 'and')
 * @method self whereColumn($first, $operator, $second, $boolean = 'and')
 * @method self whereIn($column, $values = [], $boolean = 'and', $not = false)
 * @method self whereNotIn($column, $values = [], $boolean = 'and')
 * @method self whereBetween($column, $values, $boolean = 'and', $not = false)
 * @method self whereNotBetween($column, $values, $boolean = 'and')
 * @method self whereNull($column, $boolean = 'and', $not = false)
 * @method self whereNotNull($column, $boolean = 'and')
 */
class UniqueDefinition extends Fluent
{
}
