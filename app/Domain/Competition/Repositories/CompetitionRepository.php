<?php

declare(strict_types=1);

namespace App\Domain\Competition\Repositories;

use App\Domain\Competition\DTO\CompetitionDTO;
use App\Models\CompetitionMetaModel;

class CompetitionRepository
{
    /**
     * Model metadata compétition.
     */
    private CompetitionMetaModel $metaModel;

    public function __construct()
    {
        $this->metaModel = new CompetitionMetaModel();

        log_message(
            'debug',
            '[CompetitionRepository] Repository initialized'
        );
    }

    /**
     * Retourne une compétition par son code.
     */
    public function findByCode(
        string $competitionCode
    ): ?CompetitionDTO {

        /*
        |--------------------------------------------------------------------------
        | Competition path
        |--------------------------------------------------------------------------
        */

        $competitionPath = WRITEPATH
            . 'competitions/'
            . $competitionCode;

        /*
        |--------------------------------------------------------------------------
        | Check directory existence
        |--------------------------------------------------------------------------
        */

        if (! is_dir($competitionPath)) {

            log_message(
                'error',
                '[CompetitionRepository] Competition directory not found',
                [
                    'code' => $competitionCode,
                    'path' => $competitionPath,
                ]
            );

            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Load metadata
        |--------------------------------------------------------------------------
        */

        $meta = $this->metaModel
            ->where('code', $competitionCode)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Resolve title
        |--------------------------------------------------------------------------
        */

        $title = $meta['source_label']
            ?? $competitionCode;

        /*
        |--------------------------------------------------------------------------
        | DTO construction
        |--------------------------------------------------------------------------
        */

        $competition = new CompetitionDTO(
            $competitionCode,
            $title,
            $competitionPath
        );

        /*
        |--------------------------------------------------------------------------
        | Logging
        |--------------------------------------------------------------------------
        */

        log_message(
            'debug',
            sprintf(
                '[CompetitionRepository] Competition hydrated | code=%s | title=%s',
                $competition->code,
                $competition->title
            )
        );

        return $competition;
    }
}
