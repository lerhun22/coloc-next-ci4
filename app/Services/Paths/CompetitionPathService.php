<?php

declare(strict_types=1);

namespace App\Services\Paths;

/**
 * --------------------------------------------------------------------------
 * CompetitionPathService
 * --------------------------------------------------------------------------
 *
 * Source UNIQUE des chemins filesystem runtime compétition.
 *
 * Règles :
 * - writable-first
 * - aucun ROOTPATH ailleurs dans l'application
 * - centralisation des paths runtime
 * - fallback legacy temporaire autorisé
 *
 * --------------------------------------------------------------------------
 */
class CompetitionPathService
{
    /**
     * Retourne le dossier runtime d'une compétition.
     */
    public function getCompetitionRuntimePath(string $code): string
    {
        return WRITEPATH . 'competitions/' . $code . '/';
    }

    /**
     * Retourne le dossier photos runtime.
     */
    public function getCompetitionPhotosPath(string $code): string
    {
        return $this->getCompetitionRuntimePath($code) . 'photos/';
    }

    /**
     * Fallback legacy temporaire.
     */
    public function getLegacyCompetitionPhotosPath(string $code): string
    {
        return ROOTPATH . 'legacy/competitions/' . $code . '/photos/';
    }
}
