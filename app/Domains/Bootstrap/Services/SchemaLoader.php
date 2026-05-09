<?php

namespace App\Domains\Bootstrap\Services;

class SchemaLoader
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function load(string $schemaPath): void
    {

        // dd($schemaPath);

        $files = glob($schemaPath . '/*.sql');

        //dd($files);

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
