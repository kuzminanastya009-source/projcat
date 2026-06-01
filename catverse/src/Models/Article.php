<?php

namespace Src\Models;

use Src\Services\Db;
use PDO;

class Article
{
    public $id;
    public $title;
    public $text;
    public $author_id;
    public $created_at;

    // Получить все статьи
    public static function getAll(): array
    {
        $db = Db::getConnection();
        $stmt = $db->query("SELECT * FROM articles ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Получить статью по ID
    public static function getById(int $id)
    {
        $db = Db::getConnection();
        $stmt = $db->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchObject();
    }

    // Создать статью
    public static function create(string $title, string $text, int $author_id)
    {
        $db = Db::getConnection();
        $stmt = $db->prepare("INSERT INTO articles (title, text, author_id, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$title, $text, $author_id]);
    }

    // Обновить статью
    public static function update(int $id, string $title, string $text)
    {
        $db = Db::getConnection();
        $stmt = $db->prepare("UPDATE articles SET title = ?, text = ? WHERE id = ?");
        $stmt->execute([$title, $text, $id]);
    }
}
