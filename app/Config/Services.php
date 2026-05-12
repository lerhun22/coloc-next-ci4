<?php

namespace Config;

use App\Domain\Competition\Repositories\CompetitionRepository;
use App\Domain\Competition\Runtime\ActivationCompetitionService;
use App\Domain\Competition\Runtime\CompetitionPathService;
use App\Domain\Competition\Runtime\RuntimeService;
use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    /*
    |--------------------------------------------------------------------------
    | RuntimeService
    |--------------------------------------------------------------------------
    */

    public static function runtime(
        bool $getShared = true
    ): RuntimeService {

        if ($getShared) {
            return static::getSharedInstance(
                'runtime'
            );
        }

        return new RuntimeService(
            new CompetitionPathService()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ActivationCompetitionService
    |--------------------------------------------------------------------------
    */

    public static function activationCompetition(
        bool $getShared = true
    ): ActivationCompetitionService {

        if ($getShared) {
            return static::getSharedInstance(
                'activationCompetition'
            );
        }

        return new ActivationCompetitionService(
            new CompetitionRepository(),
            static::runtime()
        );
    }



    public static function runtimeImage(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('runtimeImage');
        }

        return new \App\Services\Runtime\RuntimeImageService(
            new \App\Services\Paths\CompetitionPathService()
        );
    }


    public static function runtimePhoto(
        bool $getShared = true
    ) {
        if ($getShared) {
            return static::getSharedInstance(
                'runtimePhoto'
            );
        }

        return new \App\Services\Runtime\RuntimePhotoProvider(
            new \App\Services\Paths\CompetitionPathService()
        );
    }
}
