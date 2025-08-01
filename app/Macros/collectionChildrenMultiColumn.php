<?php
use Illuminate\Support\Collection;

Collection::macro('withChildren', function (
    array $columns,                // conditions kiểu [['location_id', '=', 'location_id']]
    Collection $modelChildren,     // collection con đã load sẵn (ví dụ OrderItem::whereIn(...)->get())
    string $parentField = 'id',
    string $childField = 'parent_id',
    string $relationName = 'children' // tên relation để gán, mặc định là 'children'
) {
    return $this->map(function ($parent) use ($columns, $modelChildren, $parentField, $childField, $relationName) {
        // Lọc các bản ghi con theo điều kiện cột
        $filtered = $modelChildren->filter(function ($child) use ($columns, $parent) {
            foreach ($columns as $condition) {
                $parentCol = $condition[0] ?? null;
                $operator  = $condition[1] ?? '=';
                $childCol  = $condition[2] ?? $parentCol;

                $parentVal = data_get($parent, $parentCol);
                $childVal  = data_get($child, $childCol);

                // So sánh đơn giản (chỉ hỗ trợ =, !=, >, <, >=, <=)
                switch ($operator) {
                    case '=':
                        if ($childVal != $parentVal) return false;
                        break;
                    case '!=':
                        if ($childVal == $parentVal) return false;
                        break;
                    case '>':
                        if ($childVal <= $parentVal) return false;
                        break;
                    case '<':
                        if ($childVal >= $parentVal) return false;
                        break;
                    case '>=':
                        if ($childVal < $parentVal) return false;
                        break;
                    case '<=':
                        if ($childVal > $parentVal) return false;
                        break;
                    default:
                        return false;
                }
            }

            return true;
        });

        // Gán vào quan hệ (dùng setRelation nếu muốn giống Eloquent)
        $parent->setRelation($relationName, $filtered->values());
        return $parent;
    });
});

