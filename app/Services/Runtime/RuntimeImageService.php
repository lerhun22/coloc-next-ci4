<?php

declare(strict_types=1);

namespace App\Services\Runtime;

use App\Services\Paths\CompetitionPathService;

/**
 * --------------------------------------------------------------------------
 * RuntimeImageService
 * --------------------------------------------------------------------------
 *
 * Résolution centralisée des images runtime.
 *
 * Responsabilités :
 * - writable-first
 * - fallback legacy
 * - résolution filesystem
 * - observabilité runtime
 *
 * Aucun :
 * - HTML
 * - Response HTTP
 * - SQL
 * - Session
 *
 * --------------------------------------------------------------------------
 */
class RuntimeImageService
{
    public function __construct(
        protected CompetitionPathService $pathService
    ) {}

    /**
     * Résout une image runtime compétition.
     */
    public function resolve(string $competitionCode, string $file): ?array
    {
        log_message(
            'info',
            '[RuntimeImageService] Resolve image | competition={competition} | file={file}',
            [
                'competition' => $competitionCode,
                'file' => $file,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Writable-first
        |--------------------------------------------------------------------------
        */

        $runtimePath =
            $this->pathService->getCompetitionPhotosPath($competitionCode)
            . $file;

        if (is_file($runtimePath)) {

            log_message(
                'info',
                '[RuntimeImageService] Runtime image found | path={path}',
                [
                    'path' => $runtimePath,
                ]
            );

            return [
                'exists' => true,
                'path'   => $runtimePath,
                'source' => 'runtime',
                'mime'   => mime_content_type($runtimePath),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Legacy fallback
        |--------------------------------------------------------------------------
        */

        $legacyPath =
            $this->pathService->getLegacyCompetitionPhotosPath($competitionCode)
            . $file;

        if (is_file($legacyPath)) {

            log_message(
                'warning',
                '[RuntimeImageService] Legacy fallback used | path={path}',
                [
                    'path' => $legacyPath,
                ]
            );

            return [
                'exists' => true,
                'path'   => $legacyPath,
                'source' => 'legacy',
                'mime'   => mime_content_type($legacyPath),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Not found
        |--------------------------------------------------------------------------
        */

        log_message(
            'error',
            '[RuntimeImageService] Image not found | competition={competition} | file={file}',
            [
                'competition' => $competitionCode,
                'file' => $file,
            ]
        );

        return null;
    }
}
