<?php

namespace Src\Models;

use Src\Services\Db;
use PDO;

class Comment
{
    public static function getByCat(int $catId): array
    {
        $db = Db::getConnection();
        $stmt = $db->prepare("SELECT * FROM comments WHERE cat_id = ? ORDER BY id DESC");
        $stmt->execute([$catId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function create(int $catId, string $author, string $text)
    {
        $db = Db::getConnection();
        $stmt = $db->prepare("INSERT INTO comments (cat_id, author, text) VALUES (?, ?, ?)");
        $stmt->execute([$catId, $author, $text]);
    }
}
