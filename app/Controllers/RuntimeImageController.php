<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\Paths\PathsService;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * ============================================================================
 * COLOC NEXT
 * ============================================================================
 * Objet : Serveur runtime des images compétition
 * ============================================================================
 */

final class RuntimeImageController extends BaseController
{
    /**
     * Retourne une image runtime.
     */
    public function show(
        string $package,
        string $filename
    ) {

        $paths = new PathsService();

        $file = $paths->images($package)
            . $filename;

        if (! is_file($file)) {
            throw PageNotFoundException::forPageNotFound();
        }

        /*
        |--------------------------------------------------------------------------
        | MIME
        |--------------------------------------------------------------------------
        */

        $mime = mime_content_type($file);

        if ($mime === false) {
            $mime = 'application/octet-stream';
        }

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setBody(file_get_contents($file));
    }
}
