<?php

declare(strict_types=1);

namespace App\Domain\Competition\Runtime;

use App\Domain\Competition\DTO\CompetitionDTO;

final class CompetitionPathService
{
    /**
     * Liste des dossiers runtime standard.
     */
    private const DIRECTORIES = [
        'photos',
        'imports',
        'exports',
        'logs',
        'cache',
    ];

    /**
     * Retourne le dossier racine compétition.
     */
    public function getCompetitionPath(
        CompetitionDTO $competition
    ): string {

        return WRITEPATH
            . 'competitions/'
            . $competition->code
            . '/';
    }

    /**
     * Retourne le dossier photos.
     */
    public function getPhotosPath(
        CompetitionDTO $competition
    ): string {

        return $this->getCompetitionPath(
            $competition
        ) . 'photos/';
    }

    /**
     * Garantit l'existence
     * des dossiers runtime.
     */
    public function ensureCompetitionDirectories(
        CompetitionDTO $competition
    ): void {

        $basePath = $this->getCompetitionPath(
            $competition
        );

        /*
        |--------------------------------------------------------------------------
        | Root directory
        |--------------------------------------------------------------------------
        */

        if (! is_dir($basePath)) {

            mkdir(
                $basePath,
                0777,
                true
            );

            log_message(
                'info',
                sprintf(
                    '[CompetitionPathService] Directory created | path=%s',
                    $basePath
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Runtime subdirectories
        |--------------------------------------------------------------------------
        */

        foreach (self::DIRECTORIES as $directory) {

            $path = $basePath
                . $directory
                . '/';

            if (is_dir($path)) {
                continue;
            }

            mkdir(
                $path,
                0777,
                true
            );

            log_message(
                'debug',
                sprintf(
                    '[CompetitionPathService] Runtime directory created | path=%s',
                    $path
                )
            );
        }
    }
}
