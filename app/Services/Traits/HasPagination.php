<?php

namespace App\Services\Traits;

trait HasPagination
{
    protected function getPaginationData($paginator): array
    {
        return [
            'total_items' => $paginator->total(),
            'items_per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'previous_page' => $paginator->previousPageUrl(),
            'next_page' => $paginator->nextPageUrl(),
        ];
    }
}
