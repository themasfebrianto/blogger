@php
    // Expected variables passed into this partial:
    // $id       => table HTML id (string)
    // $ajax     => route or URL for Ajax source (string)
    // $columns  => array of [label, key, orderable?, searchable?]
    // $order    => [columnIndex, 'asc'|'desc'] (optional)
    // $options  => extra DataTables config (optional)

    // Build JS-safe columns array in PHP to avoid Blade/PHP parsing issues
    $dtColumns = array_map(function ($c) {
        return [
            'data' => $c[1] ?? null,
            'name' => $c[1] ?? null,
            'orderable' => $c[2] ?? true,
            'searchable' => $c[3] ?? true,
        ];
    }, $columns);
@endphp

<div class="table-responsive">
    <table id="{{ $id }}" class="table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                @foreach ($columns as $col)
                    <th>{{ $col[0] ?? '' }}</th>
                @endforeach
            </tr>
        </thead>
    </table>
</div>
@push('scripts')
    <script>
        $(function() {
            const columns = @json($dtColumns);
            const options = @json($options ?? []);

            const defaultConfig = {
                processing: true,
                serverSide: true,
                ajax: "{{ $ajax }}",
                columns: columns,
                order: @json($order ?? [0, 'asc']),
                responsive: true,
                autoWidth: false,
                language: {
                    searchPlaceholder: 'Search...',
                    search: '',
                    lengthMenu: '_MENU_ entries per page',
                }
            };

            // Convert stringified functions back to actual JS functions
            if (options.ajax && typeof options.ajax.data === 'string' && options.ajax.data.startsWith('function')) {
                options.ajax.data = eval(`(${options.ajax.data})`);
            }

            const config = $.extend(true, {}, defaultConfig, options);

            $(`#{{ $id }}`).DataTable(config);
        });
    </script>
@endpush
