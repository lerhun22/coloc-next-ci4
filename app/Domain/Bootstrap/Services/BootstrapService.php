<?php

namespace App\Domain\Bootstrap\Services;

use App\Domain\Competition\Services\ActiveCompetitionService;
use App\Domain\Competition\Services\CompetitionFilesystemInitializer;
use App\Domain\Competition\Services\CompetitionPackageLoader;
use App\Domain\Bootstrap\Services\SchemaLoader;

class BootstrapService
{
    public function initialize(): array
    {
        $competitionId = 293;

        $competitionCode = '2020_N_293_00_0099';

        /*
        |--------------------------------------------------------------------------
        | 1. Load schema
        |--------------------------------------------------------------------------
        */

        $schemaLoader = new SchemaLoader();

        $schemaLoader->load(
            ROOTPATH . 'storage/bootstrap/schema'
        );

        /*
        |--------------------------------------------------------------------------
        | 2. Load competition data
        |--------------------------------------------------------------------------
        */

        $loader = new CompetitionPackageLoader();

        $result = $loader->load(
            ROOTPATH
                . 'storage/bootstrap/competition/'
                . $competitionCode
        );

        /*
        |--------------------------------------------------------------------------
        | 3. Initialize runtime filesystem
        |--------------------------------------------------------------------------
        */

        $filesystem = new CompetitionFilesystemInitializer();

        $filesystem->initialize(
            $competitionCode
        );

        /*
        |--------------------------------------------------------------------------
        | 4. Activate competition
        |--------------------------------------------------------------------------
        */

        $activeCompetition = new ActiveCompetitionService();

        $activeCompetition->set(
            $competitionId
        );

        return [
            'status' => 'success',
            'competition_id' => $competitionId,
            'competition_code' => $competitionCode,
            'loader' => $result
        ];
    }

    public function initializeDB(): array
    {
        $schemaLoader = new SchemaLoader();

        $schemaLoader->load(
            ROOTPATH . 'storage/bootstrap/schema'
        );

        $packageLoader = new CompetitionPackageLoader();

        return $packageLoader->load(
            ROOTPATH
                . 'storage/bootstrap/competition/2020_N_293_00_0099'
        );
    }
    public function checkBase(): array
    {
        $db = db_connect();

        $competitionExists = $db->table('competitions')
            ->countAllResults();

        if ($competitionExists > 0) {

            return [
                'status' => 'already_initialized'
            ];
        }

        // futur loader package

        return [
            'status' => 'bootstrap_needed'
        ];
    }
}


/*

BootstrapController
        ↓
BootstrapService
        ↓
CompetitionPackageLoader
        ↓
SQL files

*/

/*

CI4 Migrations
        ↓
Schema DB

Competition Package
        ↓
Data bootstrap

*/

/*

/Applications/MAMP/Library/bin/mysqldump \
-u root \
-proot \
-P 8889 \
--no-data \
coloc \
competitions \
competition_meta \
participants \
clubs \
photos \
> schema_bootstrap.sql

*/

/*

storage/
└── bootstrap/
    ├── schema/
    │   ├── competitions.sql
    │   ├── participants.sql
    │   ├── photos.sql
    │   └── ...
    │
    └── competition/
        └── 2020_N_293_00_0099/
            ├── sql/
            ├── photos/
            └── metadata.json

*/

/*

SchemaLoader
        ↓
Application schema

CompetitionPackageLoader
        ↓
Competition data

ActiveCompetitionService
        ↓
Runtime state

*/


/*

1. créer schéma
2. copier package bootstrap
3. charger package depuis uploads
4. définir active competition

storage/bootstrap/competition
        ↓ copy

uploads/competitions
        ↓ load

CompetitionPackageLoader


*/