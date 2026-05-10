<?php

declare(strict_types=1);

namespace App\Domain\Competition\Repositories;

use App\Domain\Competition\DTO\CompetitionDTO;

final class CompetitionRepository
{
    public function findById(
        int $id
    ): ?CompetitionDTO {

        $db = db_connect();

        /*
        |--------------------------------------------------------------------------
        | Competition
        |--------------------------------------------------------------------------
        */

        $competition = $db
            ->table('competitions')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (! $competition) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Competition meta
        |--------------------------------------------------------------------------
        */

        $meta = $db
            ->table('competition_meta')
            ->where('competition_id', $id)
            ->get()
            ->getRowArray();

        if (! $meta) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Runtime DTO
        |--------------------------------------------------------------------------
        */

        return new CompetitionDTO(
            (int) $competition['id'],
            (string) $meta['code'],
            (string) $competition['nom'],
        );
    }
}
