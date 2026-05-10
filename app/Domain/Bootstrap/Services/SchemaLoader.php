<?php

namespace App\Domain\Bootstrap\Services;

class SchemaLoader
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function load(string $schemaPath): void
    {

        $files = glob($schemaPath . '/*.sql');

        foreach ($files as $file) {

            $sql = file_get_contents($file);

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
    }
}
