<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TestDb extends Controller
{
    public function index()
    {
        $db = db_connect();

        try {
            $db->query('SELECT 1');

            return 'DB OK';
        } catch (\Throwable $e) {

            return $e->getMessage();
        }
    }
}
