<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * --------------------------------------------------------------------------
 * RuntimeDebugController
 * --------------------------------------------------------------------------
 *
 * Contrôleur temporaire de validation runtime.
 *
 * À supprimer ou protéger plus tard.
 *
 * --------------------------------------------------------------------------
 */
class RuntimeDebugController extends BaseController
{
    public function image(): void
    {
        log_message(
            'info',
            '[RuntimeDebugController] Runtime image debug started'
        );

        $service = service('runtimeImage');

        dd(
            $service->resolve(
                '2020_N_293_00_0099',
                '061929000101.jpg'
            )
        );
    }
}
