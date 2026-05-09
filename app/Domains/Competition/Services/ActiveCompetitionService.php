<?php

namespace App\Domains\Competition\Services;

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

    public function get(): ?int
    {
        return session($this->sessionKey);
    }

    public function exists(): bool
    {
        return !empty($this->get());
    }
}
