<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Coloc extends BaseConfig
{
    /**
     * ---------------------------------------------------------
     * STORAGE ROOT
     * ---------------------------------------------------------
     * Racine des compétitions importées.
     */

    public string $storageRoot = WRITEPATH . 'competitions';

    /**
     * ---------------------------------------------------------
     * DEBUG RUNTIME
     * ---------------------------------------------------------
     */

    public bool $debugRuntime = true;

    /**
     * ---------------------------------------------------------
     * LEGACY FALLBACK
     * ---------------------------------------------------------
     * Autorise fallback anciens chemins.
     */

    public bool $allowLegacyFallback = true;

    /**
     * ---------------------------------------------------------
     * VERIFY FILESYSTEM
     * ---------------------------------------------------------
     */

    public bool $verifyFilesystem = true;
}
