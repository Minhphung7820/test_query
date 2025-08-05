<?php
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

Collection::macro('withChildrenPerParent', function (
    Builder $childQuery,
    array $matchColumns,
    string $relationName = 'children',
    int $limit = 10,
    ?Closure $extraQuery = null
) {
    return $this->map(function ($parent) use ($childQuery, $matchColumns, $relationName, $limit, $extraQuery) {
        $query = clone $childQuery;

        foreach ($matchColumns as $cond) {
            $parentCol = $cond[0];
            $operator  = $cond[1] ?? '=';
            $childCol  = $cond[2] ?? $parentCol;
            $parentVal = data_get($parent, $parentCol);

            $query->where($childCol, $operator, $parentVal);
        }

        if ($extraQuery) {
            $query = $extraQuery($query);
        }

        $children = $query->limit($limit)->get();
        $parent->setRelation($relationName, $children);

        return $parent;
    });
});
