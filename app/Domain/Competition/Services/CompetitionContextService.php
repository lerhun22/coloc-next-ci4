<?php

declare(strict_types=1);

namespace App\Domain\Competition\Services;

use App\Domain\Competition\DTO\CompetitionDTO;
use App\Domain\Competition\Repositories\CompetitionRepository;

/**
 * ============================================================================
 * COLOC NEXT
 * ============================================================================
 * Date   : 2026-05-09
 * Auteur : COLOC NEXT
 * Objet  : Runtime centralisé de la compétition active
 * ============================================================================
 *
 * RESPONSABILITÉS
 * ----------------------------------------------------------------------------
 * - centraliser la compétition active
 * - encapsuler l'accès session
 * - sécuriser le runtime compétition
 * - fournir un contexte métier unique
 *
 * IMPORTANT
 * ----------------------------------------------------------------------------
 * - aucun accès direct session() ailleurs dans le projet
 * - tous les domaines passent par ce service
 * - évite les dépendances cachées
 *
 * ============================================================================
 */

final class CompetitionContextService
{
    /**
     * =========================================================================
     * Session key officielle
     * =========================================================================
     */

    private const SESSION_KEY = 'activeCompetitionId';

    /**
     * =========================================================================
     * Constructor
     * =========================================================================
     */

    public function __construct(
        protected CompetitionRepository $repository =
        new CompetitionRepository(),
    ) {}

    /**
     * =========================================================================
     * Définit la compétition active
     * =========================================================================
     */

    public function setActiveCompetition(
        int $competitionId
    ): void {

        session()->set(
            self::SESSION_KEY,
            $competitionId
        );
    }

    /**
     * =========================================================================
     * Retourne l'ID actif
     * =========================================================================
     */

    public function getActiveCompetitionId(): ?int
    {
        $id = session(self::SESSION_KEY);

        return $id !== null
            ? (int) $id
            : null;
    }

    /**
     * =========================================================================
     * Vérifie présence compétition active
     * =========================================================================
     */

    public function hasActiveCompetition(): bool
    {
        return $this->getActiveCompetition() !== null;
    }

    /**
     * =========================================================================
     * Retourne la compétition active
     * =========================================================================
     *
     * Sécurise automatiquement :
     * - session invalide
     * - compétition supprimée
     * - ID inexistant
     *
     * =========================================================================
     */

    public function getActiveCompetition(): ?CompetitionDTO
    {
        $id = $this->getActiveCompetitionId();

        if (! $id) {
            return null;
        }

        $competition =
            $this->repository->findById($id);

        /*
        |--------------------------------------------------------------------------
        | Sécurité runtime
        |--------------------------------------------------------------------------
        */

        if (! $competition) {

            session()->remove(
                self::SESSION_KEY
            );

            return null;
        }

        return $competition;
    }

    /**
     * =========================================================================
     * Garantit une compétition active
     * =========================================================================
     *
     * Cas gérés :
     * - première installation
     * - session vide
     * - session invalide
     *
     * =========================================================================
     */

    public function ensureActiveCompetition(): ?CompetitionDTO
    {
        /*
        |--------------------------------------------------------------------------
        | Déjà active
        |--------------------------------------------------------------------------
        */

        $competition =
            $this->getActiveCompetition();

        if ($competition) {
            return $competition;
        }

        /*
        |--------------------------------------------------------------------------
        | Fallback première compétition disponible
        |--------------------------------------------------------------------------
        */

        $competitions =
            $this->repository->findAll();

        if (empty($competitions)) {
            return null;
        }

        $first = $competitions[0];

        $this->setActiveCompetition(
            $first->id
        );

        return $first;
    }

    /**
     * =========================================================================
     * Supprime la compétition active
     * =========================================================================
     */

    public function clear(): void
    {
        session()->remove(
            self::SESSION_KEY
        );
    }
}
