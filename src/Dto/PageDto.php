<?php

namespace App\Dto;

final class PageDto
{
    public readonly int $totalPages;

    public function __construct(
        public readonly array $items,
        public readonly int $numero,
        public readonly int $parPage,
        public readonly int $total,
    ) {
        $this->totalPages = max(1, (int) ceil($total / $parPage));
    }
}