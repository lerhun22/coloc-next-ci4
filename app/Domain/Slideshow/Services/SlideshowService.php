<?php

declare(strict_types=1);

namespace App\Domain\Slideshow\Services;

use App\Domain\Slideshow\DTO\SlideImageDTO;
use App\Domain\Runtime\Services\RuntimeService;
use App\Services\Paths\PathsService;

/**
 * ============================================================================
 * COLOC NEXT
 * ============================================================================
 * Date   : 2026-05-08
 * Auteur : COLOC NEXT
 * Objet  : Service minimal de navigation slideshow
 * ============================================================================
 *
 * Responsabilités :
 * - récupérer la compétition active
 * - scanner les images runtime
 * - construire les DTO slideshow
 * - fournir une navigation simple par index
 * ============================================================================
 */

final class SlideshowService
{
    public function __construct(
        private readonly RuntimeService $runtime,
        private readonly PathsService $paths,
    ) {}

    /**
     * Retourne une slide par index.
     */
    public function getSlide(int $index): ?SlideImageDTO
    {
        $competition = $this->runtime->getCompetition();

        if ($competition === null) {
            return null;
        }

        $images = $this->loadImages($competition->code);

        if (! isset($images[$index])) {
            return null;
        }

        $file = $images[$index];

        return new SlideImageDTO(
            index: $index,
            filename: $file,
            title: pathinfo($file, PATHINFO_FILENAME),
            score: null,
            imageUrl: $this->paths->imageUrl($competition->code, $file),
        );
    }

    /**
     * Nombre total d'images.
     */
    public function count(): int
    {
        $competition = $this->runtime->getCompetition();

        if ($competition === null) {
            return 0;
        }

        return count($this->loadImages($competition->code));
    }

    /**
     * Charge les images depuis le runtime filesystem.
     */
    private function loadImages(string $package): array
    {
        $directory = $this->paths->images($package);

        log_message('debug', "Chargement des images pour le package: {$package}");
        log_message('debug', "Répertoire: {$directory}");
        $a = is_dir($directory);
        log_message('debug', "Le répertoire existe-t-il? " . ($a ? 'Oui' : 'Non'));
        if (! is_dir($directory)) {
            return [];
        }

        $files = scandir($directory);

        log_message('debug', "Répertoire: {$directory}, fichiers trouvés: " . count($files));

        if ($files === false) {
            return [];
        }

        $images = [];

        foreach ($files as $file) {

            if (in_array($file, ['.', '..'], true)) {
                continue;
            }

            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                continue;
            }

            $images[] = $file;
        }

        sort($images);




        return array_values($images);
    }
}
