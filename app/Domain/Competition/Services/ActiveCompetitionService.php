<?php

namespace App\Domain\Competition\Services;

use App\Domain\Competition\DTO\CompetitionDTO;
use App\Domain\Competition\Repositories\CompetitionRepository;

class ActiveCompetitionService
{
    protected string $sessionKey = 'active_competition_id';

    public function set(int $competitionId): void
    {
        session()->set(
            $this->sessionKey,
            $competitionId
        );
    }

    public function getId(): ?int
    {
        return session($this->sessionKey);
    }

    public function exists(): bool
    {
        return !empty($this->getId());
    }

    public function getCompetition(): ?CompetitionDTO
    {
        $id = $this->getId();

        if (!$id) {
            return null;
        }

        $repository = new CompetitionRepository();

        return $repository->find($id);
    }
}
