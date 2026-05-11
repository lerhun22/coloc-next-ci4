<?php

declare(strict_types=1);

namespace App\Domain\Competition\Runtime;

use App\Domain\Competition\DTO\CompetitionDTO;

final class RuntimeDTO
{
    public function __construct(
        public readonly bool $active,
        public readonly ?CompetitionDTO $competition,
        public readonly array $paths = [],
    ) {}

    public static function inactive(): self
    {
        return new self(
            active: false,
            competition: null,
            paths: [],
        );
    }

    public function hasCompetition(): bool
    {
        return $this->competition !== null;
    }
}
