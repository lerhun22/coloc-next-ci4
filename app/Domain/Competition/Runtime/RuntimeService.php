<?php

declare(strict_types=1);

namespace App\Domain\Competition\Runtime;

use App\Config\CompetitionRegistry;
use App\Domain\Competition\DTO\CompetitionDTO;
use App\Domain\Competition\Repositories\CompetitionRepository;

class RuntimeService
{
    /**
     * Repository métier compétition.
     */
    private CompetitionRepository $repository;

    /**
     * Runtime session key.
     */
    private const SESSION_ACTIVE_COMPETITION = 'activeCompetition';

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
        return session(self::SESSION_ACTIVE_COMPETITION);
    }

    /**
     * Définit la compétition active.
     */
    public function activateCompetition(string $competitionCode): void
    {
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

        if ($code === null) {

            log_message(
                'warning',
                '[RuntimeService] No active competition in session'
            );

            return null;
        }

        $competition = $this->repository->findByCode($code);

        if ($competition === null) {

            log_message(
                'error',
                '[RuntimeService] Competition not found: {code}',
                [
                    'code' => $code,
                ]
            );

            return null;
        }

        log_message(
            'debug',
            '[RuntimeService] Active competition loaded: {code}',
            [
                'code' => $competition->code,
            ]
        );

        return $competition;
    }

    /**
     * Vérifie si une compétition est active.
     */
    public function hasActiveCompetition(): bool
    {
        return $this->getActiveCompetitionCode() !== null;
    }
}
