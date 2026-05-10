<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Competition\Repositories\CompetitionRepository;
use App\Domain\Competition\Services\ActiveCompetitionService;
use App\Domain\Import\Services\ImportLoaderService;
use App\Services\Paths\PathsService;

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
     * -------------------------------------------------------------------------
     * Charge une compétition dans le runtime moderne
     * -------------------------------------------------------------------------
     */
    public function load(int $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Repository métier officiel
        |--------------------------------------------------------------------------
        */

        $repository =
            new CompetitionRepository();

        $competition =
            $repository->findById($id);

        /*
        |--------------------------------------------------------------------------
        | Sécurité
        |--------------------------------------------------------------------------
        */

        if (! $competition) {

            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status'  => 'error',
                    'message' => 'Compétition introuvable',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Active runtime competition
        |--------------------------------------------------------------------------
        */

        $activeCompetition =
            new ActiveCompetitionService();

        $activeCompetition->set(
            $competition->id
        );

        /*
        |--------------------------------------------------------------------------
        | Runtime loader
        |--------------------------------------------------------------------------
        */

        $loader = new ImportLoaderService(
            new PathsService()
        );

        $result = $loader->load(
            $competition
        );

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return $this->response
            ->setJSON([
                'status'      => 'success',
                'competition' => [
                    'id'   => $competition->id,
                    'code' => $competition->code,
                    'name' => $competition->name,
                ],
                'runtime' => $result,
            ]);
    }
}
