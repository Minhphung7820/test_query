<?php
use Illuminate\Database\Eloquent\Relations\HasMany;

HasMany::macro('whereColumnsMatchModel', function (array $columns) {
    /** @var \Illuminate\Database\Eloquent\Relations\HasMany $this */
    $model = $this->getParent();

    return $this->where(function ($query) use ($columns, $model) {
        foreach ($columns as $condition) {
            $parentField = $condition[0] ?? null;
            $operator    = $condition[1] ?? '=';
            $childField  = $condition[2] ?? $parentField;

            $parentValue = $model->{$parentField} ?? null;

            if ($parentValue === null) continue;

            $query->where($childField, $operator, $parentValue);
        }
    });
});

