<?php

namespace App\Controllers;

use App\Domain\Competition\Repositories\CompetitionRepository;
use App\Domain\Competition\Services\ActiveCompetitionService;

class CompetitionController extends BaseController
{
    public function load(int $id)
    {
        $repository = new CompetitionRepository();

        $competition = $repository->find($id);

        if ($competition === null) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $activeCompetition = new ActiveCompetitionService();

        $activeCompetition->set(
            $competition->id
        );

        return $this->response->setJSON([
            'status' => 'success',
            'competition' => $competition
        ]);
    }
}
