<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Competition\Repositories\CompetitionRepository;
use App\Domain\Competition\Runtime\ActivationCompetitionService;
use App\Domain\Competition\Runtime\RuntimeService;

class RuntimeController extends BaseController
{
    public function test(): string
    {
        $runtime = new RuntimeService();

        $activation =
            new ActivationCompetitionService(
                new CompetitionRepository(),
                $runtime
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
