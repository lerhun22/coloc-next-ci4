<?php
/*
1. créer dossiers
2. copier assets bootstrap
3. vérifier permissions

SchemaLoader
        ↓
DB structure

CompetitionPackageLoader
        ↓
DB data

CompetitionFilesystemInitializer
        ↓
Runtime assets


*/


namespace App\Domains\Competition\Services;

class CompetitionFilesystemInitializer
{
    public function initialize(string $competitionCode): array
    {
        /*
        |--------------------------------------------------------------------------
        | Source bootstrap package
        |--------------------------------------------------------------------------
        */

        $sourceBase = ROOTPATH
            . 'storage/bootstrap/competition/'
            . $competitionCode;

        /*
        |--------------------------------------------------------------------------
        | Runtime destination
        |--------------------------------------------------------------------------
        */

        $destinationBase = ROOTPATH
            . 'writable/competitions/'
            . $competitionCode;

        /*
        |--------------------------------------------------------------------------
        | Required directories
        |--------------------------------------------------------------------------
        */

        $folders = [
            'images',
            'thumbs',
            'export',
            'csv',
            'pdf',
            'pte',
            'temp',
        ];

        /*
        |--------------------------------------------------------------------------
        | Create base directory
        |--------------------------------------------------------------------------
        */

        if (!is_dir($destinationBase)) {

            mkdir($destinationBase, 0777, true);
        }

        /*
        |--------------------------------------------------------------------------
        | Create and copy folders
        |--------------------------------------------------------------------------
        */

        foreach ($folders as $folder) {

            $destination = $destinationBase . '/' . $folder;

            if (!is_dir($destination)) {

                mkdir($destination, 0777, true);
            }

            $source = $sourceBase . '/' . $folder;

            if (!is_dir($source)) {
                continue;
            }

            $files = glob($source . '/*');

            foreach ($files as $file) {

                $target = $destination
                    . '/'
                    . basename($file);

                copy($file, $target);
            }
        }

        return [
            'status' => 'success',
            'destination' => $destinationBase
        ];
    }
}
