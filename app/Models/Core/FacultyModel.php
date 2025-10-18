<?php

namespace TheFramework\Models\Core;

use TheFramework\App\CacheManager;
use TheFramework\App\Database;
use TheFramework\App\Config;
use TheFramework\App\Logging;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Exception;
use TheFramework\App\Model;
use TheFramework\Helpers\Helper;

class FacultyModel extends Model {
    protected $table = 'faculties';
    protected $primaryKey = 'uid';
}