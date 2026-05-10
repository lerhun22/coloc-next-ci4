<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class CompetitionMetaModel extends Model
{
    protected $table = 'competition_meta';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'competition_code',
        'source_label',
    ];
}
