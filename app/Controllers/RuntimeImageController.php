<?php

declare(strict_types=1);

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

final class RuntimeImageController extends BaseController
{
    public function show(
        string $competitionCode,
        string $filename
    ) {

        log_message(
            'debug',
            '[RuntimeImageController] Image requested'
                . ' | competition=' . $competitionCode
                . ' | filename=' . $filename
        );

        /*
        |--------------------------------------------------------------------------
        | Sécurité minimale
        |--------------------------------------------------------------------------
        */

        if (str_contains($filename, '..')) {

            log_message(
                'error',
                '[RuntimeImageController] Invalid filename'
                    . ' | filename=' . $filename
            );

            throw PageNotFoundException
                ::forPageNotFound();
        }

        /*
        |--------------------------------------------------------------------------
        | Runtime image resolution
        |--------------------------------------------------------------------------
        */

        $image = service('runtimeImage')->resolve(
            $competitionCode,
            $filename
        );

        if ($image === null) {

            log_message(
                'error',
                '[RuntimeImageController] Image not found'
                    . ' | competition=' . $competitionCode
                    . ' | filename=' . $filename
            );

            throw PageNotFoundException
                ::forPageNotFound();
        }

        /*
        |--------------------------------------------------------------------------
        | Response image
        |--------------------------------------------------------------------------
        */

        return $this->response
            ->setHeader(
                'Content-Type',
                $image['mime']
            )
            ->setHeader(
                'Cache-Control',
                'public, max-age=3600'
            )
            ->setBody(
                file_get_contents($image['path'])
            );
    }
}
