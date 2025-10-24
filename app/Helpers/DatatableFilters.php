<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class DatatableFilters
{
    /**
     * Apply smart, generic filters and search to a query builder for DataTables.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $searchableColumns  Columns for text search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function applyFilters(Builder $query, Request $request, array $searchableColumns = [])
    {
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search, $searchableColumns) {
                if (empty($searchableColumns)) {
                    // Default fallback: search 'title' or 'name'
                    $searchableColumns = ['title', 'name'];
                }

                foreach ($searchableColumns as $column) {
                    if (str_contains($column, '.')) {
                        [$relation, $col] = explode('.', $column, 2);
                        $q->orWhereHas($relation, fn($r) => $r->where($col, 'like', "%{$search}%"));
                    } else {
                        $q->orWhere($column, 'like', "%{$search}%");
                    }
                }
            });
        }

        $ignoredKeys = ['search', 'columns', 'order', 'start', 'length', '_token', '_', 'draw'];
        $filters = collect($request->except($ignoredKeys))->filter(fn($v) => $v !== null && $v !== '');

        foreach ($filters as $key => $value) {
            // Handle range filters like created_at_from / created_at_to
            if (preg_match('/^(.*)_from$/', $key, $matches)) {
                $column = $matches[1];
                $toKey = "{$column}_to";
                $from = $value;
                $to = $filters->get($toKey);
                if ($to) {
                    $query->whereBetween($column, [$from, $to]);
                } else {
                    $query->where($column, '>=', $from);
                }
                continue;
            }

            // Handle array filters (multi-selects)
            if (is_array($value)) {
                $query->whereIn($key, $value);
                continue;
            }

            if (str_contains($key, '.')) {
                [$relation, $col] = explode('.', $key, 2);
                $query->whereHas($relation, fn($r) => $r->where($col, $value));
                continue;
            }

            if (str_ends_with($key, '_id')) {
                $relation = str_replace('_id', '', $key);
                if (method_exists($query->getModel(), $relation)) {
                    $query->whereHas($relation, fn($r) => $r->where('id', $value));
                    continue;
                }
            }

            // Fallback: simple equality
            $query->where($key, $value);
        }


        return $query;
    }
}
