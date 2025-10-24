<?php

use Illuminate\Support\Facades\Route;

if (! function_exists('datatable_actions')) {
    /**
     * Generate Edit/Delete icon buttons for DataTables row
     *
     * @param string|int $editUrl
     * @param string|int $deleteUrl
     * @param bool $confirm
     * @return string
     */
    function datatable_actions($editUrl, $deleteUrl, $confirm = true)
    {
        $confirmAttr = $confirm ? "onclick=\"return confirm('Are you sure?')\"" : "";

        return '
            <a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
            <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                ' . csrf_field() . method_field('DELETE') . '
                <button type="submit" class="btn btn-sm btn-danger" title="Delete" ' . $confirmAttr . '>
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        ';
    }
}
