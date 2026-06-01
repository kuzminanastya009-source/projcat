<?php

namespace Src\Models;

use Src\Services\Db;
use PDO;

class Cat
{
    public static function getAll(): array
    {
        $db = Db::getConnection();
        $stmt = $db->query("SELECT * FROM cats ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getById(int $id)
    {
        $db = Db::getConnection();
        $stmt = $db->prepare("SELECT * FROM cats WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchObject();
    }

    
    public static function create(string $name, int $age, string $color, ?string $photo, int $authorId)
    {
        $db = Db::getConnection();
        $stmt = $db->prepare("INSERT INTO cats (name, age, color, photo, author_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $age, $color, $photo, $authorId]);
    }

    public static function update(int $id, string $name, int $age, string $color, ?string $photo)
    {
        $db = Db::getConnection();

        if ($photo) {
            $stmt = $db->prepare("UPDATE cats SET name = ?, age = ?, color = ?, photo = ? WHERE id = ?");
            $stmt->execute([$name, $age, $color, $photo, $id]);
        } else {
            $stmt = $db->prepare("UPDATE cats SET name = ?, age = ?, color = ? WHERE id = ?");
            $stmt->execute([$name, $age, $color, $id]);
        }
    }

    public static function delete(int $id)
    {
        $db = Db::getConnection();
        $stmt = $db->prepare("DELETE FROM cats WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function calculateHumanAge(int $age): int
    {
        if ($age <= 0) return 0;
        if ($age == 1) return 15;
        if ($age == 2) return 24;

        return 24 + ($age - 2) * 4;
    }

    public static function getColors(): array
    {
        $db = Db::getConnection();
        $stmt = $db->query("SELECT DISTINCT color FROM cats ORDER BY color ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function getPaginated(array $params, int $limit, int $offset): array
    {
        $db = Db::getConnection();

        $sql = "SELECT * FROM cats WHERE 1=1";
        $values = [];

        // 🔍 Поиск
        if (!empty($params['q'])) {
            $sql .= " AND (name LIKE ? OR color LIKE ?)";
            $values[] = "%{$params['q']}%";
            $values[] = "%{$params['q']}%";
        }

        // 🎨 Фильтр по цвету
        if (!empty($params['color'])) {
            $sql .= " AND color = ?";
            $values[] = $params['color'];
        }

        // 🔢 Фильтр по возрасту
        if (!empty($params['age_min'])) {
            $sql .= " AND age >= ?";
            $values[] = $params['age_min'];
        }

        if (!empty($params['age_max'])) {
            $sql .= " AND age <= ?";
            $values[] = $params['age_max'];
        }

        // ⚙️ Сортировка
        $allowedSort = ['name', 'age', 'color'];
        $allowedDir = ['ASC', 'DESC'];

        $sort = $params['sort'] ?? 'id';
        $dir = $params['dir'] ?? 'ASC';

        if (!in_array($sort, $allowedSort)) $sort = 'id';
        if (!in_array($dir, $allowedDir)) $dir = 'ASC';

        $sql .= " ORDER BY $sort $dir LIMIT $limit OFFSET $offset";

        $stmt = $db->prepare($sql);
        $stmt->execute($values);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function countFiltered(array $params): int
    {
        $db = Db::getConnection();

        $sql = "SELECT COUNT(*) FROM cats WHERE 1=1";
        $values = [];

        if (!empty($params['q'])) {
            $sql .= " AND (name LIKE ? OR color LIKE ?)";
            $values[] = "%{$params['q']}%";
            $values[] = "%{$params['q']}%";
        }

        if (!empty($params['color'])) {
            $sql .= " AND color = ?";
            $values[] = $params['color'];
        }

        // 🔢 Фильтр по возрасту
        if (!empty($params['age_min'])) {
            $sql .= " AND age >= ?";
            $values[] = $params['age_min'];
        }

        if (!empty($params['age_max'])) {
            $sql .= " AND age <= ?";
            $values[] = $params['age_max'];
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($values);

        return (int)$stmt->fetchColumn();
    }

    public static function toggleFavorite(int $id)
    {
        $db = Db::getConnection();
        $stmt = $db->prepare("UPDATE cats SET favorite = NOT favorite WHERE id = ?");
        $stmt->execute([$id]);
    }

    public static function getFavorites(): array
    {
        $db = Db::getConnection();
        $stmt = $db->query("SELECT * FROM cats WHERE favorite = 1 ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function like(int $id)
    {
        $db = Db::getConnection();
        $stmt = $db->prepare("UPDATE cats SET likes = likes + 1 WHERE id = ?");
        $stmt->execute([$id]);
    }
    // Получить популярные клички
public static function getPopularNames(): array
{
    $db = Db::getConnection();
    $stmt = $db->query("
        SELECT name, COUNT(*) as count 
        FROM cats 
        WHERE name IS NOT NULL 
        GROUP BY name 
        ORDER BY count DESC 
        LIMIT 10
    ");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
}

// Получить популярные породы
public static function getPopularBreeds(): array
{
    $db = Db::getConnection();
    $stmt = $db->query("
        SELECT breed, COUNT(*) as count 
        FROM cats 
        WHERE breed IS NOT NULL 
        GROUP BY breed 
        ORDER BY count DESC 
        LIMIT 5
    ");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
}
}
