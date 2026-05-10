<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Domain\Competition\Services\ActiveCompetitionService;

abstract class BaseController extends Controller
{
    /**
     * -------------------------------------------------------------------------
     * Helpers
     * -------------------------------------------------------------------------
     */

    protected $helpers = [];

    /**
     * -------------------------------------------------------------------------
     * Runtime competition
     * -------------------------------------------------------------------------
     */

    protected ActiveCompetitionService $activeCompetition;

    /**
     * -------------------------------------------------------------------------
     * Init controller
     * -------------------------------------------------------------------------
     */

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController(
            $request,
            $response,
            $logger
        );

        /*
        |--------------------------------------------------------------------------
        | Active competition runtime
        |--------------------------------------------------------------------------
        */

        $this->activeCompetition =
            new ActiveCompetitionService();
    }
}
