<?php

declare(strict_types=1);

namespace App\Domain\Competition\Runtime;

use App\Domain\Competition\DTO\CompetitionDTO;
use App\Domain\Competition\Runtime\CompetitionPathService;
use App\Domain\Competition\Runtime\RuntimeDTO;

final class RuntimeService
{
    private const SESSION_ACTIVE_COMPETITION =
    'activeCompetition';

    public function __construct(
        private readonly CompetitionPathService $pathService,
    ) {}

    public function current(): RuntimeDTO
    {
        $competition = session()->get(
            self::SESSION_ACTIVE_COMPETITION
        );

        if (! $competition instanceof CompetitionDTO) {
            return RuntimeDTO::inactive();
        }

        return new RuntimeDTO(
            active: true,
            competition: $competition,
            paths: [
                'root' => $this->pathService
                    ->getCompetitionPath($competition),

                'photos' => $this->pathService
                    ->getPhotosPath($competition),
            ]
        );
    }

    public function setActiveCompetition(
        CompetitionDTO $competition
    ): void {

        session()->set(
            self::SESSION_ACTIVE_COMPETITION,
            $competition
        );
    }

    public function clear(): void
    {
        session()->remove(
            self::SESSION_ACTIVE_COMPETITION
        );
    }
}
