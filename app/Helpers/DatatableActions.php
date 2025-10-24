<?php

use Illuminate\Support\Facades\Route;

if (! function_exists('datatable_actions')) {
    /**
     * Generate optional Edit/Delete icon buttons for DataTables row
     *
     * @param string|null $editUrl
     * @param string|null $deleteUrl
     * @param bool $confirm
     * @return string
     */
    function datatable_actions(?string $editUrl = null, ?string $deleteUrl = null, bool $confirm = true): string
    {
        $buttons = [];

        // Add Edit button if URL provided
        if ($editUrl) {
            $buttons[] = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>';
        }

        // Add Delete button if URL provided
        if ($deleteUrl) {
            $confirmAttr = $confirm ? "onclick=\"return confirm('Are you sure?')\"" : "";
            $buttons[] = '<form action="' . $deleteUrl . '" method="POST" style="display:inline-block; margin:0;" onsubmit="return confirm(\'Are you sure?\');">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" ' . $confirmAttr . '>
                                <i class="fas fa-trash-alt"></i>
                            </button>
                          </form>';
        }


        // Wrap buttons in a flex container for proper spacing
        return '<div class="d-flex gap-1 align-items-center">' . implode('', $buttons) . '</div>';
    }
}
