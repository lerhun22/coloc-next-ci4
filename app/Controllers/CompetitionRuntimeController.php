<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domains\Competition\DTO\CompetitionDTO;
use App\Domains\Import\Services\ImportLoaderService;
use App\Services\Paths\PathsService;
use App\Services\Runtime\RuntimeService;

/**
 * ============================================================================
 * COLOC NEXT
 * ============================================================================
 * Objet : Activation runtime d'une compétition
 * ============================================================================
 */

final class CompetitionRuntimeController extends BaseController
{
    /**
     * Charge une compétition dans le runtime moderne.
     */
    public function load(int $id)
    {
        /*
        |--------------------------------------------------------------------------
        | TEMPORAIRE
        |--------------------------------------------------------------------------
        |
        | Plus tard :
        | - CompetitionRepository
        | - base SQL réelle
        |
        */

        $competition = new CompetitionDTO(
            id: $id,
            code: '2020_N_293_00_0099',
            name: 'Compétition test',
        );

        $loader = new ImportLoaderService(
            new PathsService(),
            new RuntimeService(),
        );

        $result = $loader->load(
            $competition
        );

        return $this->response->setJSON($result);
    }
}
