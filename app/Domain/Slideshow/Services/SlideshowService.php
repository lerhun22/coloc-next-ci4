<?php

declare(strict_types=1);

namespace App\Domain\Slideshow\Services;

use App\Domain\Competition\Runtime\RuntimeDTO;

final class SlideshowService
{
    /**
     * Charge les slides du runtime actif.
     *
     * @return array<int, array<string, mixed>>
     */
    public function load(
        RuntimeDTO $runtime
    ): array {

        log_message(
            'debug',
            '[SlideshowService] Loading slideshow'
        );

        /*
        |--------------------------------------------------------------------------
        | Vérification runtime actif
        |--------------------------------------------------------------------------
        */

        if (! $runtime->active) {

            log_message(
                'warning',
                '[SlideshowService] No active runtime'
            );

            return [];
        }

        /*
        |--------------------------------------------------------------------------
        | Vérification path photos
        |--------------------------------------------------------------------------
        */

        $photosPath = $runtime->paths['photos'] ?? null;

        if ($photosPath === null) {

            log_message(
                'error',
                '[SlideshowService] Missing photos path'
                    . ' | code=' . $runtime->competition->code
            );

            return [];
        }

        log_message(
            'debug',
            '[SlideshowService] Photos path resolved'
                . ' | path=' . $photosPath
        );

        /*
        |--------------------------------------------------------------------------
        | Vérification existence dossier
        |--------------------------------------------------------------------------
        */

        if (! is_dir($photosPath)) {

            log_message(
                'error',
                '[SlideshowService] Photos directory missing'
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
            $photosPath . '*.{jpg,jpeg,JPG,JPEG,png,PNG}',
            GLOB_BRACE
        );

        if ($files === false) {

            log_message(
                'error',
                '[SlideshowService] Photos scan failed'
                    . ' | path=' . $photosPath
            );

            return [];
        }

        log_message(
            'debug',
            '[SlideshowService] Photos directory scanned'
                . ' | files=' . count($files)
        );

        /*
        |--------------------------------------------------------------------------
        | Construction slides
        |--------------------------------------------------------------------------
        */

        $slides = [];

        foreach ($files as $file) {

            $slides[] = [
                'filename' => basename($file),
                'filepath' => $file,

                'url' => '/runtime/image/'
                    . $runtime->competition->code
                    . '/'
                    . basename($file),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Slideshow prêt
        |--------------------------------------------------------------------------
        */

        log_message(
            'debug',
            '[SlideshowService] Slideshow ready'
                . ' | competition=' . $runtime->competition->code
                . ' | slides=' . count($slides)
        );

        return $slides;
    }
}
