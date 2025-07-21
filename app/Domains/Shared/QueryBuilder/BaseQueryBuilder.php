<?php

namespace App\Domains\Shared\QueryBuilder;

use Illuminate\Database\Eloquent\Builder;

/**
 * @template T
 *
 * @extends Builder<T>
 */
class BaseQueryBuilder extends Builder
{
    public function fromUuid(string $uuid): self
    {
        return $this->where('uuid', $uuid);
    }
}
