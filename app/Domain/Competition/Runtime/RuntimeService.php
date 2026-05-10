<?php

declare(strict_types=1);

namespace App\Domain\Competition\Runtime;

use App\Domain\Competition\DTO\CompetitionDTO;
use App\Domain\Competition\Repositories\CompetitionRepository;

class RuntimeService
{
    /**
     * Session key utilisée pour la compétition active.
     */
    private const SESSION_ACTIVE_COMPETITION =
    'activeCompetition';

    /**
     * Repository métier compétition.
     */
    private CompetitionRepository $repository;

    public function __construct()
    {
        $this->repository = new CompetitionRepository();

        log_message(
            'debug',
            '[RuntimeService] RuntimeService initialized'
        );
    }

    /**
     * Retourne le code de la compétition active.
     */
    public function getActiveCompetitionCode(): ?string
    {
        return session(
            self::SESSION_ACTIVE_COMPETITION
        );
    }

    /**
     * Active une compétition dans la session runtime.
     */
    public function activateCompetition(
        string $competitionCode
    ): void {

        session()->set(
            self::SESSION_ACTIVE_COMPETITION,
            $competitionCode
        );

        log_message(
            'info',
            '[RuntimeService] Competition activated: {code}',
            [
                'code' => $competitionCode,
            ]
        );
    }

    /**
     * Retourne la compétition active.
     */
    public function getActiveCompetition(): ?CompetitionDTO
    {
        $code = $this->getActiveCompetitionCode();

        /*
        |--------------------------------------------------------------------------
        | No active competition
        |--------------------------------------------------------------------------
        */

        if ($code === null) {

            log_message(
                'warning',
                '[RuntimeService] No active competition in session'
            );

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Load competition
        |--------------------------------------------------------------------------
        */

        $competition = $this->repository
            ->findByCode($code);

        /*
        |--------------------------------------------------------------------------
        | Competition not found
        |--------------------------------------------------------------------------
        */

        if ($competition === null) {

            log_message(
                'error',
                '[RuntimeService] Competition not found',
                [
                    'code' => $code,
                ]
            );

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Runtime hydrated
        |--------------------------------------------------------------------------
        */

        log_message(
            'debug',
            sprintf(
                '[RuntimeService] Active competition loaded | code=%s | title=%s',
                $competition->code,
                $competition->title
            )
        );

        return $competition;
    }

    /**
     * Vérifie si une compétition active existe.
     */
    public function hasActiveCompetition(): bool
    {
        return $this->getActiveCompetitionCode()
            !== null;
    }
}
