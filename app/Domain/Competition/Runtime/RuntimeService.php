<?php

declare(strict_types=1);

namespace App\Domain\Competition\Runtime;

use App\Domain\Competition\DTO\CompetitionDTO;

/**
 * ============================================================================
 * COLOC NEXT
 * ============================================================================
 * Runtime central COLOC NEXT
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
    private const SESSION_ACTIVE_COMPETITION =
    'activeCompetition';

    /**
     * Retourne la compétition active.
     */
    public function getActiveCompetition(): ?CompetitionDTO
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
    public function setActiveCompetition(
        CompetitionDTO $competition
    ): void {

        session()->set(
            self::SESSION_ACTIVE_COMPETITION,
            $competition
        );
    }

    /**
     * Vérifie si une compétition est active.
     */
    public function hasActiveCompetition(): bool
    {
        return $this->getActiveCompetition()
            !== null;
    }

    /**
     * Retourne le package actif.
     */
    public function getActivePackage(): ?string
    {
        return $this->getActiveCompetition()?->code;
    }

    /**
     * Nettoie le runtime actif.
     */
    public function clear(): void
    {
        session()->remove(
            self::SESSION_ACTIVE_COMPETITION
        );
    }
}
