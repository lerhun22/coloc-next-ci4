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
        | Runtime service
        |--------------------------------------------------------------------------
        */

        $runtimeService = service('runtime');

        $runtime = $runtimeService->current();

        /*
        |--------------------------------------------------------------------------
        | Vérification runtime actif
        |--------------------------------------------------------------------------
        */

        if (! $runtime->active) {

            log_message(
                'warning',
                '[RuntimeImageController] No active runtime'
            );

            throw PageNotFoundException
                ::forPageNotFound();
        }

        /*
        |--------------------------------------------------------------------------
        | Construction path image
        |--------------------------------------------------------------------------
        */

        $photosPath = $runtime->paths['photos'];

        $filepath = $photosPath . $filename;

        log_message(
            'debug',
            '[RuntimeImageController] Image path resolved'
                . ' | path=' . $filepath
        );

        log_message(
            'debug',
            '[RuntimeImageController] File exists='
                . (file_exists($filepath) ? 'YES' : 'NO')
        );

        log_message(
            'debug',
            '[RuntimeImageController] Readable='
                . (is_readable($filepath) ? 'YES' : 'NO')
        );

        /*
        |--------------------------------------------------------------------------
        | Vérification existence fichier
        |--------------------------------------------------------------------------
        */

        if (! is_file($filepath)) {

            log_message(
                'error',
                '[RuntimeImageController] Image missing'
                    . ' | path=' . $filepath
            );

            throw PageNotFoundException
                ::forPageNotFound();
        }

        /*
        |--------------------------------------------------------------------------
        | Mime type
        |--------------------------------------------------------------------------
        */

        $mime = mime_content_type($filepath);

        log_message(
            'debug',
            '[RuntimeImageController] Image ready'
                . ' | mime=' . $mime
        );

        /*
        |--------------------------------------------------------------------------
        | Response image
        |--------------------------------------------------------------------------
        */

        return $this->response
            ->setHeader(
                'Content-Type',
                $mime
            )
            ->setBody(
                file_get_contents($filepath)
            );
    }
}
