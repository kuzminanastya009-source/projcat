<?php

namespace Src\Controllers;

use Src\View\View;
use Src\Models\Cat;
use Src\Models\Comment;

class CatController
{
    public function index()
    {
        $params = [
            'q' => $_GET['q'] ?? '',
            'color' => $_GET['color'] ?? '',
            'age_min' => $_GET['age_min'] ?? '',
            'age_max' => $_GET['age_max'] ?? '',
        ];

        $page = $_GET['page'] ?? 1;
        $page = max(1, (int)$page);

        $limit = 10;
        $offset = ($page - 1) * $limit;

        $total = Cat::countFiltered($params);
        $cats = Cat::getPaginated($params, $limit, $offset);
        $pages = ceil($total / $limit);

        $colors = Cat::getColors();
        
        // Получаем популярную статистику
        $popularNames = Cat::getPopularNames();
        $popularBreeds = Cat::getPopularBreeds();

        View::render('cats/list.php', [
            'cats' => $cats,
            'params' => $params,
            'colors' => $colors,
            'page' => $page,
            'pages' => $pages,
            'title' => 'Все коты',
            'popularNames' => $popularNames,
            'popularBreeds' => $popularBreeds
        ]);
    }

    public function show(int $id)
    {
        $cat = Cat::getById($id);

        if (!$cat) {
            echo "Кот не найден";
            return;
        }

        View::render('cats/view.php', [
            'cat' => $cat,
            'title' => $cat->name
        ]);
    }

    public function create()
    {
        $this->ensureAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? null;
            $age = (int)($_POST['age'] ?? 0);
            $color = $_POST['color'] ?? null;
            $authorId = $_SESSION['user']['id'];

            $photo = null;
            if (!empty($_FILES['photo']['name'])) {
                $uploadDir = __DIR__ . '/../../public/uploads/cats/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $photoName = time() . '_' . basename($_FILES['photo']['name']);
                $uploadPath = $uploadDir . $photoName;
                move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath);
                $photo = $photoName;
            }

            Cat::create($name, $age, $color, $photo, $authorId);

            header('Location: /cats');
            exit;
        }

        View::render('cats/create.php', [
            'title' => 'Добавить кота'
        ]);
    }

    public function edit(int $id)
    {
        $cat = Cat::getById($id);

        if (!$cat) {
            echo "Кот не найден";
            return;
        }

        $user = $_SESSION['user'] ?? null;
        if (!$user || ($user['role'] !== 'admin' && $cat->author_id !== $user['id'])) {
            echo "У вас нет прав на редактирование этой записи.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $age = (int)($_POST['age'] ?? 0);
            $color = $_POST['color'] ?? '';

            $photo = null;
            if (!empty($_FILES['photo']['name'])) {
                $uploadDir = __DIR__ . '/../../public/uploads/cats/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $photoName = time() . '_' . basename($_FILES['photo']['name']);
                $uploadPath = $uploadDir . $photoName;
                move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath);
                $photo = $photoName;
            }

            Cat::update($id, $name, $age, $color, $photo);

            header("Location: /cat/$id");
            exit;
        }

        View::render('cats/edit.php', [
            'cat' => $cat,
            'title' => 'Редактировать кота'
        ]);
    }

    public function delete(int $id)
    {
        $cat = Cat::getById($id);

        if (!$cat) {
            echo "Кот не найден";
            return;
        }

        $user = $_SESSION['user'] ?? null;
        if (!$user || ($user['role'] !== 'admin' && $cat->author_id !== $user['id'])) {
            echo "У вас нет прав на удаление этой записи.";
            return;
        }

        Cat::delete($id);
        header("Location: /cats");
        exit;
    }

    public function age(int $id)
    {
        $cat = Cat::getById($id);

        if (!$cat) {
            echo "Кот не найден";
            return;
        }

        $humanAge = Cat::calculateHumanAge($cat->age);

        View::render('cats/age.php', [
            'cat' => $cat,
            'humanAge' => $humanAge,
            'title' => 'Возраст кота'
        ]);
    }

    public function like(int $id)
    {
        // Проверка авторизации
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $catId = $id;

        $db = \Src\Services\Db::getConnection();

        // Проверяем, лайкал ли уже этот пользователь
        $stmt = $db->prepare("SELECT id FROM cat_likes WHERE user_id = ? AND cat_id = ?");
        $stmt->execute([$userId, $catId]);
        $existingLike = $stmt->fetch(\PDO::FETCH_OBJ);

        if ($existingLike) {
            // Если уже лайкал — убираем лайк (toggle)
            $stmt = $db->prepare("DELETE FROM cat_likes WHERE user_id = ? AND cat_id = ?");
            $stmt->execute([$userId, $catId]);
            
            // Уменьшаем счетчик лайков
            $stmt = $db->prepare("UPDATE cats SET likes = likes - 1 WHERE id = ? AND likes > 0");
            $stmt->execute([$catId]);
        } else {
            // Если не лайкал — добавляем лайк
            try {
                $stmt = $db->prepare("INSERT INTO cat_likes (user_id, cat_id) VALUES (?, ?)");
                $stmt->execute([$userId, $catId]);
                
                // Увеличиваем счетчик лайков
                $stmt = $db->prepare("UPDATE cats SET likes = likes + 1 WHERE id = ?");
                $stmt->execute([$catId]);
            } catch (\PDOException $e) {
                // Если ошибка UNIQUE constraint — значит уже лайкнул
                // Просто игнорируем
            }
        }

        // Возвращаемся на страницу кота
        header("Location: /cat/$catId");
        exit;
    }

    public function comment(int $id)
    {
        $this->ensureAuth();

        $author = $_SESSION['user']['nickname'] ?? 'Аноним';
        $text = $_POST['text'] ?? '';

        if ($text !== '') {
            Comment::create($id, $author, $text);
        }

        header("Location: /cat/$id");
        exit;
    }

    private function ensureAuth()
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }

    // ЕДИНСТВЕННЫЙ метод favorite (улучшенный)
    public function favorite(int $id)
    {
        $this->ensureAuth();
        Cat::toggleFavorite($id);
        
        // Проверяем, откуда пришел пользователь
        $referer = $_SERVER['HTTP_REFERER'] ?? '/cats';
        
        // Извлекаем путь из URL
        $parsedUrl = parse_url($referer, PHP_URL_PATH);
        
        // Разрешенные страницы для возврата
        $allowedPages = ['/cats', '/favorites', '/articles'];
        
        // Проверяем, является ли страница разрешенной
        $isValidRedirect = false;
        foreach ($allowedPages as $page) {
            if (strpos($parsedUrl, $page) === 0) {
                $isValidRedirect = true;
                break;
            }
        }
        
        // Если страница разрешена - возвращаемся туда
        if ($isValidRedirect) {
            header("Location: $referer");
        } else {
            // Иначе перенаправляем на страницу кота
            header("Location: /cat/$id");
        }
        exit;
    }
    
    public function favorites()
    {
        // Проверка авторизации
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        // Получаем всех котов, которые в избранном (favorite = 1)
        $db = \Src\Services\Db::getConnection();
        $stmt = $db->prepare("
            SELECT c.* 
            FROM cats c
            WHERE c.favorite = 1
            ORDER BY c.id DESC
        ");
        $stmt->execute();
        $cats = $stmt->fetchAll(\PDO::FETCH_OBJ);

        \Src\View\View::render('cats/favorites.php', [
            'cats' => $cats,
            'title' => 'Избранные коты'
        ]);
    }
}