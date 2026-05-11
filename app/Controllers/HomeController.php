<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Competition\Runtime\RuntimeService;

final class HomeController extends BaseController
{
    private RuntimeService $runtimeService;

    public function __construct()
    {
        $this->runtimeService = service('runtime');

        log_message(
            'debug',
            '[HomeController] Runtime service initialized'
        );
    }

    public function index(): string
    {
        log_message(
            'debug',
            '[HomeController] Home requested'
        );

        /*
        |--------------------------------------------------------------------------
        | Runtime courant
        |--------------------------------------------------------------------------
        */

        $runtime = $this->runtimeService->current();

        log_message(
            'debug',
            '[HomeController] Runtime loaded'
                . ' | active=' . ($runtime->active ? 'yes' : 'no')
        );

        /*
        |--------------------------------------------------------------------------
        | Aucune compétition active
        |--------------------------------------------------------------------------
        */

        if (! $runtime->active) {

            log_message(
                'warning',
                '[HomeController] No active competition'
            );

            return view(
                'home/no_active_competition',
                [
                    'runtime' => $runtime,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Runtime actif
        |--------------------------------------------------------------------------
        */

        log_message(
            'debug',
            '[HomeController] Active competition resolved'
                . ' | code=' . $runtime->competition->code
                . ' | title=' . $runtime->competition->title
        );

        /*
        |--------------------------------------------------------------------------
        | Home runtime-aware
        |--------------------------------------------------------------------------
        */

        return view(
            'home/index',
            [
                'runtime' => $runtime,
            ]
        );
    }
}
