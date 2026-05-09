<?php

declare(strict_types=1);

namespace App\Domains\Competition\DTO;

/**
 * ============================================================================
 * COLOC NEXT
 * ============================================================================
 * Date   : 2026-05-08
 * Auteur : COLOC NEXT
 * Objet  : DTO immutable représentant une compétition
 * ============================================================================
 */

final readonly class CompetitionDTO
{
    public function __construct(
        public int $id,
        public string $code,
        public string $name,
    ) {}
}
