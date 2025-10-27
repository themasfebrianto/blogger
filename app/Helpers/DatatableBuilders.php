<?php

namespace App\Helpers;

class DatatableBuilders
{
    protected array $config = [
        'id' => null,
        'ajax' => null,
        'columns' => [],
        'order' => [],
        'options' => [
            'ajax' => [],
        ],
    ];

    /**
     * Static entry point for fluent builder.
     */
    public static function make(string $id): self
    {
        $instance = new self();
        $instance->config['id'] = $id;
        return $instance;
    }

    /**
     * Set the AJAX URL.
     */
    public function ajax(string $url): self
    {
        $this->config['ajax'] = $url;
        $this->config['options']['ajax']['url'] = $url;
        return $this;
    }

    /**
     * Add multiple columns at once.
     */
    public function columns(array $columns): self
    {
        $this->config['columns'] = $columns;
        return $this;
    }

    /**
     * Add a single column (chainable).
     */
    public function addColumn(
        string $label,
        string $key,
        bool $orderable = true,
        bool $searchable = true
    ): self {
        $this->config['columns'][] = [$label, $key, $orderable, $searchable];
        return $this;
    }

    /**
     * Define default sort order.
     */
    public function order(int $index, string $direction = 'asc'): self
    {
        $this->config['order'] = [[$index, $direction]];
        return $this;
    }

    /**
     * Define full AJAX data callback (JS function body as string).
     */
    public function ajaxData(string $functionBody): self
    {
        $this->config['options']['ajax']['data'] = $functionBody;
        return $this;
    }

    /**
     * Add individual AJAX parameter dynamically (auto-wraps into a function).
     * Example:
     *   ->ajaxDataParam('category', '$("#filter-category").val()')
     */
    public function ajaxDataParam(string $param, string $jsValue): self
    {
        $existing = $this->config['options']['ajax']['data'] ?? null;

        // if not yet a function, start a new one
        if (!$existing || !str_starts_with(trim($existing), 'function')) {
            $existing = "function(d) { d.$param = $jsValue; }";
        } else {
            // inject new line before closing brace
            $existing = preg_replace(
                '/\}$/',
                "  d.$param = $jsValue;\n}",
                trim($existing)
            );
        }

        $this->config['options']['ajax']['data'] = $existing;
        return $this;
    }

    /**
     * Merge any additional options.
     */
    public function options(array $options): self
    {
        $this->config['options'] = array_replace_recursive($this->config['options'], $options);
        return $this;
    }

    /**
     * Final build output.
     */
    public function build(): array
    {
        return $this->config;
    }
}
