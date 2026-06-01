<?php

namespace Src\Models;

use Src\Services\Db;
use PDO;

class User
{
    public static function getById(int $id)
    {
        $db = Db::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchObject();
    }
}
