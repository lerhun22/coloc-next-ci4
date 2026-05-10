<?php

declare(strict_types=1);

namespace App\Domain\Competition\DTO;

class CompetitionDTO
{
    /**
     * Identifiant technique unique.
     *
     * Exemple :
     * 2020_N_293_00_0099
     */
    public string $code;

    /**
     * Nom métier affichable.
     *
     * Exemple :
     * "National Nature UR22 2020"
     *
     * Provient de :
     * competition_meta.source_label
     */
    public string $title;

    /**
     * Chemin racine de la compétition.
     */
    public string $path;

    public function __construct(
        string $code,
        string $title,
        string $path
    ) {
        $this->code  = $code;
        $this->title = $title;
        $this->path  = $path;
    }
}
