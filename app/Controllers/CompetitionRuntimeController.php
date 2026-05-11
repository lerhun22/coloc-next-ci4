<?php

declare(strict_types=1);

namespace App\Controllers;

final class CompetitionRuntimeController extends BaseController
{
    public function test(): string
    {
        log_message(
            'debug',
            '[RuntimeController] Runtime test started'
        );

        /*
        |--------------------------------------------------------------------------
        | Services runtime
        |--------------------------------------------------------------------------
        */

        $activation = service(
            'activationCompetition'
        );

        $runtimeService = service(
            'runtime'
        );

        /*
        |--------------------------------------------------------------------------
        | Activation compétition test
        |--------------------------------------------------------------------------
        */

        $activation->activate(
            '2020_N_293_00_0099'
        );

        log_message(
            'debug',
            '[RuntimeController] Competition activated'
                . ' | code=2020_N_293_00_0099'
        );

        /*
        |--------------------------------------------------------------------------
        | Runtime courant
        |--------------------------------------------------------------------------
        */

        $runtime = $runtimeService->current();

        if (! $runtime->active) {

            log_message(
                'warning',
                '[RuntimeController] No active competition'
            );

            return 'No active competition';
        }

        log_message(
            'debug',
            '[RuntimeController] Active runtime resolved'
                . ' | code=' . $runtime->competition->code
                . ' | title=' . $runtime->competition->title
        );

        return sprintf(
            'Active competition: %s',
            $runtime->competition->title
        );
    }
}
