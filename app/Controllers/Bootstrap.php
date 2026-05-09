<?php

/*
app/
├── Controllers/
│   └── Bootstrap.php
│
└── Domains/
    ├── Bootstrap/
    │   └── Services/
    │       └── BootstrapService.php
    │
    └── Competition/
        └── Services/
            └── CompetitionPackageLoader.php
*/

namespace App\Controllers;

use App\Domains\Bootstrap\Services\BootstrapService;

class Bootstrap extends BaseController
{
    public function index()
    {
        $service = new BootstrapService();

        $result = $service->initialize();

        return $this->response->setJSON($result);
    }

    public function checkBase()
    {
        $service = new BootstrapService();

        $result = $service->checkBase();

        return $this->response->setJSON($result);
    }
}
