<?php
declare(strict_types=1);

namespace App\ServerFilter\Filters;

use Illuminate\Database\Eloquent\Builder;

class Storage implements Filter
{
    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->whereBetween('hdd_capacity', [$value['min'], $value['max']]);
    }
}
