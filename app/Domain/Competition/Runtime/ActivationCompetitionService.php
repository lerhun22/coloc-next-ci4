<?php

declare(strict_types=1);

namespace App\Domain\Competition\Runtime;

use App\Domain\Competition\Repositories\CompetitionRepository;

final class ActivationCompetitionService
{
    public function __construct(
        private readonly CompetitionRepository $repository,
        private readonly RuntimeService $runtimeService
    ) {}

    /**
     * Active une compétition runtime.
     */
    public function activate(
        string $competitionCode
    ): bool {

        /*
        |--------------------------------------------------------------------------
        | Activation requested
        |--------------------------------------------------------------------------
        */

        log_message(
            'info',
            sprintf(
                '[ActivationCompetitionService] Activation requested | code=%s',
                $competitionCode
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Load competition
        |--------------------------------------------------------------------------
        */

        $competition = $this->repository
            ->findByCode($competitionCode);

        /*
        |--------------------------------------------------------------------------
        | Competition not found
        |--------------------------------------------------------------------------
        */

        if ($competition === null) {

            log_message(
                'warning',
                sprintf(
                    '[ActivationCompetitionService] Activation failed | code=%s | reason=competition_not_found',
                    $competitionCode
                )
            );

            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Activate runtime
        |--------------------------------------------------------------------------
        */

        $this->runtimeService
            ->setActiveCompetition($competition);

        /*
        |--------------------------------------------------------------------------
        | Activation success
        |--------------------------------------------------------------------------
        */

        log_message(
            'info',
            sprintf(
                '[ActivationCompetitionService] Competition activated | code=%s | title=%s',
                $competition->code,
                $competition->title
            )
        );

        return true;
    }

    /**
     * Nettoie le runtime actif.
     */
    public function deactivate(): void
    {
        $this->runtimeService->clear();

        log_message(
            'info',
            '[ActivationCompetitionService] Runtime cleared'
        );
    }
}
