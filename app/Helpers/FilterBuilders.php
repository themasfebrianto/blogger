<?php

namespace App\Helpers;

use Closure;
use Illuminate\Support\Collection;

class FilterBuilders
{
    protected array $filters = [];

    /**
     * Base filter adder (used internally)
     */
    protected function add(string $type, string $name, string $placeholder, array $extra = []): self
    {
        $this->filters[] = array_merge([
            'type' => $type,
            'name' => $name,
            'placeholder' => $placeholder,
        ], $extra);

        return $this;
    }

    /**
     * Add a generic select dropdown
     */
    public function select(string $name, string $placeholder, array|Closure $options, array $attributes = []): self
    {
        return $this->add('select', $name, $placeholder, [
            'options' => $options,
            'attributes' => $attributes,
        ]);
    }

    /**
     * Add a select dropdown from a model or collection
     */
    public function selectFromModel(
        string $name,
        string $placeholder,
        Collection|array $collection,
        string $labelKey = 'name',
        string $valueKey = 'id',
        array $attributes = []
    ): self {
        $options = collect($collection)->pluck($labelKey, $valueKey)->toArray();
        return $this->select($name, $placeholder, $options, $attributes);
    }

    /**
     * Add a text input
     */
    public function text(string $name, string $placeholder, array $attributes = []): self
    {
        return $this->add('text', $name, $placeholder, ['attributes' => $attributes]);
    }

    /**
     * Add a date picker
     */
    public function date(string $name, string $placeholder = 'Date', array $attributes = []): self
    {
        return $this->add('date', $name, $placeholder, ['attributes' => $attributes]);
    }

    /**
     * Add a date range picker
     */
    public function dateRange(string $name = 'date_range', string $placeholder = 'Date Range', array $attributes = []): self
    {
        return $this->add('daterange', $name, $placeholder, ['attributes' => $attributes]);
    }

    /**
     * Add a boolean toggle / checkbox
     */
    public function toggle(string $name, string $label, array $attributes = []): self
    {
        return $this->add('toggle', $name, $label, ['attributes' => $attributes]);
    }

    /**
     * Add a custom field (any arbitrary type)
     */
    public function custom(string $type, string $name, string $placeholder, array $extra = []): self
    {
        return $this->add($type, $name, $placeholder, $extra);
    }

    /**
     * Get all filters, resolving closures (for lazy options)
     */
    public function get(): array
    {
        return array_map(function ($filter) {
            if (isset($filter['options']) && $filter['options'] instanceof Closure) {
                $filter['options'] = ($filter['options'])();
            }
            return $filter;
        }, $this->filters);
    }

    /**
     * Static helper
     */
    public static function make(): self
    {
        return new self();
    }
}
