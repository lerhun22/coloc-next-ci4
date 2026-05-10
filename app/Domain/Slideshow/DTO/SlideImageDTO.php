<?php

declare(strict_types=1);

namespace App\Domain\Slideshow\DTO;

/**
 * ============================================================================
 * COLOC NEXT
 * ============================================================================
 * Date   : 2026-05-08
 * Auteur : COLOC NEXT
 * Objet  : DTO immutable représentant une image du slideshow
 * ============================================================================
 */

final readonly class SlideImageDTO
{
    public function __construct(
        public int $index,
        public string $filename,
        public string $title,
        public ?float $score,
        public string $imageUrl,
    ) {}
}
