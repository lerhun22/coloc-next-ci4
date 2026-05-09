<?php

declare(strict_types=1);

namespace App\Services\Paths;

/**
 * ============================================================================
 * COLOC NEXT
 * ============================================================================
 * Date   : 2026-05-08
 * Auteur : COLOC NEXT
 * Objet  : Centralisation des chemins runtime compétition
 * ============================================================================
 *
 * Convention officielle :
 *
 * writable/
 * └── competitions/
 *     └── {package}/
 *         ├── images/
 *         ├── metadata/
 *         ├── thumbs/
 *         └── runtime/
 *
 * IMPORTANT :
 * - le reste du projet ne doit JAMAIS manipuler les chemins directement
 * - toute résolution passe par ce service
 * ============================================================================
 */

final class PathsService
{
    /**
     * Racine runtime compétitions.
     */
    public function competitionsRoot(): string
    {
        return WRITEPATH . 'competitions/';
    }

    /**
     * Dossier runtime d'une compétition.
     */
    public function competition(string $package): string
    {
        return $this->competitionsRoot()
            . $package
            . '/';
    }

    /**
     * Dossier images runtime.
     */
    public function images(string $package): string
    {
        return $this->competition($package)
            . 'images/';
    }

    /**
     * Dossier metadata runtime.
     */
    public function metadata(string $package): string
    {
        return $this->competition($package)
            . 'metadata/';
    }

    /**
     * Dossier thumbnails runtime.
     */
    public function thumbs(string $package): string
    {
        return $this->competition($package)
            . 'thumbs/';
    }

    /**
     * Dossier runtime interne.
     */
    public function runtime(string $package): string
    {
        return $this->competition($package)
            . 'runtime/';
    }

    /**
     * URL publique d'une image runtime.
     */
    public function imageUrl(string $package, string $filename): string
    {
        return '/runtime/image/'
            . rawurlencode($package)
            . '/'
            . rawurlencode($filename);
    }
}
