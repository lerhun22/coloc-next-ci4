<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domains\Slideshow\Services\SlideshowService;
use App\Services\Runtime\RuntimeService;
use App\Services\Paths\PathsService;


final class SlideshowController extends BaseController
{
    public function index()
    {

        return redirect()->to('/slideshow/0');
    }

    public function show(int $index = 0)
    {
        $runtime = new RuntimeService();

        $runtime->setCompetition(
            new \App\Domains\Competition\DTO\CompetitionDTO(
                id: 1,
                code: '2020_N_293_00_0099',
                name: 'Compétition test',
            )
        );

        $service = new SlideshowService(
            $runtime,
            new PathsService(),
        );

        $slide = $service->getSlide($index);

        if ($slide === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('slideshow/show', [
            'slide' => $slide,
            'index' => $index,
            'count' => $service->count(),
        ]);
    }
}
