<?php

namespace App\Dto;

final class GroupementFiltreDto
{
    // 3 groupements en fixtures : 2 par page pour voir la pagination (remets 10 après)
    public const PAR_PAGE = 2;

    public readonly ?string $ville;
    public readonly ?string $tel;
    public readonly int $page;

    public function __construct(
        ?string $ville = null,
        ?string $tel = null,
        int $page = 1,
        public readonly int $parPage = self::PAR_PAGE,
    ) {
        $this->ville = self::nettoyer($ville);
        $this->tel = self::nettoyer($tel);
        $this->page = max(1, $page);
    }

    private static function nettoyer(?string $valeur): ?string
    {
        $valeur = trim((string) $valeur);

        return $valeur === '' ? null : $valeur;
    }
}