<?php

declare(strict_types=1);

namespace App\Domain\Competition\Repositories;

use App\Domain\Competition\DTO\CompetitionDTO;

final class CompetitionRepository
{

    /**
     * Retourne une compétition par son code.
     */
    public function findByCode(
        string $competitionCode
    ): ?CompetitionDTO {

        /*
        |--------------------------------------------------------------------------
        | Source compétition
        |--------------------------------------------------------------------------
        */

        $competitionPath = WRITEPATH
            . 'competitions/'
            . $competitionCode;

        /*
        |--------------------------------------------------------------------------
        | Vérification existence
        |--------------------------------------------------------------------------
        */

        if (! is_dir($competitionPath)) {

            log_message(
                'error',
                '[CompetitionRepository] Competition directory not found: {code}',
                [
                    'code' => $competitionCode,
                ]
            );

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Construction DTO
        |--------------------------------------------------------------------------
        */

        $title = $competitionCode;


        dd($title);

        $competition = new CompetitionDTO(
            $competitionCode,
            $title,
            $competitionPath
        );

        log_message(
            'debug',
            '[CompetitionRepository] Competition DTO created: {code}',
            [
                'code' => $competition->code,
            ]
        );

        return $competition;
    }





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
