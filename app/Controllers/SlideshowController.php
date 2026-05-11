<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Slideshow\Services\SlideshowService;

final class SlideshowController extends BaseController
{
    public function index(): mixed
    {
        log_message(
            'debug',
            '[SlideshowController] Slideshow index requested'
        );

        return redirect()->to('/slideshow/0');
    }

    public function show(
        int $index = 0
    ): string {

        log_message(
            'debug',
            '[SlideshowController] Slide requested'
                . ' | index=' . $index
        );

        /*
        |--------------------------------------------------------------------------
        | Runtime courant
        |--------------------------------------------------------------------------
        */

        $runtimeService = service('runtime');

        $runtime = $runtimeService->current();

        /*
        |--------------------------------------------------------------------------
        | Vérification runtime actif
        |--------------------------------------------------------------------------
        */

        if (! $runtime->active) {

            log_message(
                'warning',
                '[SlideshowController] No active competition'
            );

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        /*
        |--------------------------------------------------------------------------
        | Slideshow service
        |--------------------------------------------------------------------------
        */

        $slideshowService = new SlideshowService();

        /*
        |--------------------------------------------------------------------------
        | Chargement slides
        |--------------------------------------------------------------------------
        */

        $slides = $slideshowService->load(
            $runtime
        );

        /*
        |--------------------------------------------------------------------------
        | Vérification slide demandée
        |--------------------------------------------------------------------------
        */

        if (! isset($slides[$index])) {

            log_message(
                'warning',
                '[SlideshowController] Slide not found'
                    . ' | index=' . $index
            );

            throw \CodeIgniter\Exceptions\PageNotFoundException
                ::forPageNotFound();
        }

        $slide = $slides[$index];

        /*
        |--------------------------------------------------------------------------
        | Slide ready
        |--------------------------------------------------------------------------
        */

        log_message(
            'debug',
            '[SlideshowController] Slide ready'
                . ' | index=' . $index
                . ' | filename=' . $slide['filename']
        );

        return view(
            'slideshow/show',
            [
                'slide' => $slide,
                'index' => $index,
                'count' => count($slides),
                'runtime' => $runtime,
            ]
        );
    }
}
