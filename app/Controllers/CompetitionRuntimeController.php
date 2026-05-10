<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Runtime\Services\ActivationCompetitionService;
use App\Domain\Runtime\Services\RuntimeService;

class RuntimeController extends BaseController
{
    public function test(): string
    {
        $activation = service(
            ActivationCompetitionService::class
        );

        $runtime = service(
            RuntimeService::class
        );

        $activation->activate(
            '2020_N_293_00_0099'
        );

        $competition = $runtime
            ->getActiveCompetition();

        if ($competition === null) {
            return 'No active competition';
        }

        return sprintf(
            'Active competition: %s',
            $competition->title
        );
    }
}
