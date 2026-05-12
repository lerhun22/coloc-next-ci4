<?php

declare(strict_types=1);

namespace App\Services\Runtime;

use App\Services\Paths\CompetitionPathService;

/**
 * --------------------------------------------------------------------------
 * RuntimePhotoProvider
 * --------------------------------------------------------------------------
 *
 * Source unique des photos runtime compétition.
 *
 * Responsabilités :
 * - résolution dossier photos
 * - scan filesystem
 * - writable-first
 * - fallback futur
 * - observabilité runtime
 *
 * Aucun :
 * - HTML
 * - slideshow
 * - Response HTTP
 * - session
 *
 * --------------------------------------------------------------------------
 */
final class RuntimePhotoProvider
{
    public function __construct(
        protected CompetitionPathService $pathService
    ) {}

    /**
     * Liste les photos runtime.
     *
     * @return array<int, string>
     */
    public function list(
        string $competitionCode
    ): array {

        log_message(
            'debug',
            '[RuntimePhotoProvider] Listing photos'
                . ' | competition=' . $competitionCode
        );

        /*
        |--------------------------------------------------------------------------
        | Runtime photos path
        |--------------------------------------------------------------------------
        */

        $photosPath = $this->pathService
            ->getCompetitionPhotosPath(
                $competitionCode
            );

        log_message(
            'debug',
            '[RuntimePhotoProvider] Photos path resolved'
                . ' | path=' . $photosPath
        );

        /*
        |--------------------------------------------------------------------------
        | Vérification dossier
        |--------------------------------------------------------------------------
        */

        if (! is_dir($photosPath)) {

            log_message(
                'error',
                '[RuntimePhotoProvider] Photos directory missing'
                    . ' | path=' . $photosPath
            );

            return [];
        }

        /*
        |--------------------------------------------------------------------------
        | Scan photos
        |--------------------------------------------------------------------------
        */

        $files = glob(
            rtrim($photosPath, '/')
                . '/*.{jpg,jpeg,JPG,JPEG,png,PNG}',
            GLOB_BRACE
        );

        if ($files === false) {

            log_message(
                'error',
                '[RuntimePhotoProvider] Photos scan failed'
                    . ' | path=' . $photosPath
            );

            return [];
        }

        log_message(
            'debug',
            '[RuntimePhotoProvider] Photos listed'
                . ' | files=' . count($files)
        );

        return $files;
    }
}
