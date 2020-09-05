<?php
declare(strict_types=1);

namespace App\ServerFilter\Filters;

use Illuminate\Database\Eloquent\Builder;

class Location implements Filter
{
    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('location', $value);
    }
}
