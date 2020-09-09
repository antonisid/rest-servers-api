<?php

namespace App\ServerFilter\Filters;

use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public static function apply(Builder $query, $value): Builder;
}
