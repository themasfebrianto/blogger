<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

if (! function_exists('datatable_actions')) {
    /**
     * Generate optional Edit/Delete icon buttons for DataTables row
     */
    function datatable_actions(?string $editUrl = null, ?string $deleteUrl = null, bool $confirm = true): string
    {
        return View::make('admin.shared.datatableActions', [
            'editUrl' => $editUrl,
            'deleteUrl' => $deleteUrl,
            'confirm' => $confirm,
        ])->render();
    }
}
