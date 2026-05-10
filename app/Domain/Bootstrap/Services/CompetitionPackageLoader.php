<?php

namespace App\Domain\Competition\Services;

class CompetitionPackageLoader
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function load(string $packagePath): array
    {
        if (!is_dir($packagePath)) {

            return [
                'status' => 'error',
                'message' => 'Package directory not found'
            ];
        }

        $sqlPath = $packagePath . '/sql';

        if (!is_dir($sqlPath)) {

            return [
                'status' => 'error',
                'message' => 'SQL directory missing'
            ];
        }

        $files = [
            'clubs.sql',
            'participants.sql',
            'competitions.sql',
            'competition_meta.sql',
            'photos.sql',
        ];

        foreach ($files as $file) {

            $fullPath = $sqlPath . '/' . $file;

            if (!file_exists($fullPath)) {
                continue;
            }

            $sql = file_get_contents($fullPath);

            if (empty($sql)) {
                continue;
            }

            $queries = array_filter(
                array_map('trim', explode(';', $sql))
            );

            foreach ($queries as $query) {

                if (empty($query)) {
                    continue;
                }

                $this->db->query($query);
            }
        }

        return [
            'status' => 'success',
            'package' => basename($packagePath)
        ];
    }
}
