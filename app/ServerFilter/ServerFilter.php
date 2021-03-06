<?php
declare(strict_types=1);

namespace App\ServerFilter;

use Illuminate\Database\Eloquent\Builder;
use App\ServerFilter\Filters\Filter;

class ServerFilter
{
    /**
     * @param array $filters
     * @param Builder $query
     * @return Builder
     */
    public static function applyFilters(array $filters, Builder $query): Builder
    {
        return static::applyFiltersFromRequest($filters, $query);
    }

    /**
     * @param array $filters
     * @param Builder $query
     * @return Builder
     */
    private static function applyFiltersFromRequest(array $filters, Builder $query): Builder
    {
        foreach ($filters as $filter => $value) {

            $filterClass = __NAMESPACE__ . '\\Filters\\' . str_replace(' ', '',
                    ucwords(str_replace('_', ' ', $filter)));

            if (class_exists($filterClass)) {
                /** @var Filter $filterClass */
                $query = $filterClass::apply($query, $value);
            }
        }

        return $query;
    }
}
