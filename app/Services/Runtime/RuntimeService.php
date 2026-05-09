<?php

declare(strict_types=1);

namespace App\Services\Runtime;

use App\Domains\Competition\DTO\CompetitionDTO;

/**
 * ============================================================================
 * COLOC NEXT
 * ============================================================================
 * Date   : 2026-05-08
 * Auteur : COLOC NEXT
 * Objet  : Runtime central COLOC NEXT
 * ============================================================================
 *
 * Responsabilités :
 * - gérer la compétition active
 * - encapsuler l'accès session runtime
 * - centraliser l'état runtime global
 * ============================================================================
 */

final class RuntimeService
{
    private const SESSION_ACTIVE_COMPETITION = 'activeCompetition';

    /**
     * Retourne la compétition active.
     */
    public function getCompetition(): ?CompetitionDTO
    {
        $competition = session()->get(
            self::SESSION_ACTIVE_COMPETITION
        );

        if (! $competition instanceof CompetitionDTO) {
            return null;
        }

        return $competition;
    }

    /**
     * Définit la compétition active.
     */
    public function setCompetition(CompetitionDTO $competition): void
    {
        session()->set(
            self::SESSION_ACTIVE_COMPETITION,
            $competition
        );
    }

    /**
     * Vérifie si une compétition est active.
     */
    public function hasCompetition(): bool
    {
        return $this->getCompetition() !== null;
    }

    /**
     * Retourne le package actif.
     */
    public function getPackage(): ?string
    {
        return $this->getCompetition()?->code;
    }

    /**
     * Supprime le runtime actif.
     */
    public function clear(): void
    {
        session()->remove(
            self::SESSION_ACTIVE_COMPETITION
        );
    }
}
