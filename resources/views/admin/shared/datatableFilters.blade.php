@props([
    'filters' => [],
    'tableId' => 'datatable',
])

<div class="card datatable-filters-card mb-3 border-0 shadow-sm">
    <div class="card-body p-3">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <span class="filter-badge">
                    <i class="fas fa-filter"></i> Filters
                </span>
            </div>

            @foreach ($filters as $filter)
                <div class="col-12 col-sm-6 col-lg-auto">
                    @if ($filter['type'] === 'select')
                        <select id="filter-{{ $filter['name'] }}" name="{{ $filter['name'] }}"
                            class="form-select form-select-sm datatable-filter" data-table="{{ $tableId }}">
                            <option value="">{{ $filter['placeholder'] ?? 'All' }}</option>
                            @foreach ($filter['options'] as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    @elseif($filter['type'] === 'date')
                        <input type="date" id="filter-{{ $filter['name'] }}" name="{{ $filter['name'] }}"
                            class="form-control form-control-sm datatable-filter"
                            placeholder="{{ $filter['placeholder'] ?? '' }}" data-table="{{ $tableId }}">
                    @elseif($filter['type'] === 'text')
                        <input type="text" id="filter-{{ $filter['name'] }}" name="{{ $filter['name'] }}"
                            class="form-control form-control-sm datatable-filter"
                            placeholder="{{ $filter['placeholder'] ?? '' }}" data-table="{{ $tableId }}">
                    @elseif($filter['type'] === 'daterange')
                        <div class="input-group input-group-sm datatable-daterange">
                            <input type="date" id="filter-{{ $filter['name'] }}_from"
                                name="{{ $filter['name'] }}_from" class="form-control form-control-sm datatable-filter"
                                placeholder="From" data-table="{{ $tableId }}">
                            <span class="input-group-text">to</span>
                            <input type="date" id="filter-{{ $filter['name'] }}_to" name="{{ $filter['name'] }}_to"
                                class="form-control form-control-sm datatable-filter" data-table="{{ $tableId }}">
                        </div>
                    @endif
                </div>
            @endforeach

            @if (!empty($filters))
                <div class="col-12 col-lg-auto ms-lg-auto">
                    <button type="button" class="reset-filters" data-table="{{ $tableId }}">
                        <i class="fas fa-rotate-left"></i> Reset Filters
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
@once
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Extend all DataTables to automatically include .datatable-filter values
                $.fn.dataTable.ext.errMode = 'throw';

                // Intercept every DataTable AJAX request and inject filters dynamically
                $.fn.dataTable.ext.ajax = $.fn.dataTable.ext.ajax || {};
                $(document).on('preXhr.dt', function(e, settings, data) {
                    const tableId = settings.sTableId;

                    // Find filters bound to this table
                    $(`.datatable-filter[data-table="${tableId}"]`).each(function() {
                        const name = $(this).attr('name');
                        const value = $(this).val();
                        if (value !== null && value !== '') {
                            data[name] = value;
                        }
                    });
                });

                // Reload on change
                $(document).on('change', '.datatable-filter', function() {
                    const tableId = $(this).data('table');
                    $(`#${tableId}`).DataTable().ajax.reload();
                });

                // Reset filters
                $(document).on('click', '.reset-filters', function() {
                    const tableId = $(this).data('table');
                    $(`.datatable-filter[data-table="${tableId}"]`).val('');
                    $(`#${tableId}`).DataTable().ajax.reload();
                });
            });
        </script>
    @endpush
@endonce
