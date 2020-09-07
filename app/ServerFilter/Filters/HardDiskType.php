<?php
declare(strict_types=1);

namespace App\ServerFilter\Filters;

use Illuminate\Database\Eloquent\Builder;

class HardDiskType implements Filter
{
    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('hdd', 'like', '%' . $value . '%');
    }
}
