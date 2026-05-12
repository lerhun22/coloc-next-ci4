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

        $files = service('runtimePhoto')->list(
            $runtime->competition->code
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


        /*
        |--------------------------------------------------------------------------
        | Vérification existence dossier
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | Scan photos
        |--------------------------------------------------------------------------
        */


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

                'url' => base_url('/runtime/image/'
                    . $runtime->competition->code
                    . '/'
                    . rawurlencode(basename($file))),
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
