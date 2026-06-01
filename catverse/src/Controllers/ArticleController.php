<?php

namespace Src\Controllers;

use Src\View\View;
use Src\Models\Article;
use Src\Models\User;

class ArticleController
{
    // Список статей
    public function index()
    {
        $articles = Article::getAll();
        $currentUser = $_SESSION['user'] ?? null;

        View::render('articles/index.php', [
            'articles' => $articles,
            'currentUser' => $currentUser,
            'title' => 'Все статьи'
        ]);
    }

    // Просмотр статьи
    public function show(int $id)
    {
        $article = Article::getById($id);

        if (!$article) {
            echo "Статья не найдена";
            return;
        }

        $author = User::getById($article->author_id);
        $currentUser = $_SESSION['user'] ?? null;

        View::render('articles/view.php', [
            'article' => $article,
            'author' => $author,
            'currentUser' => $currentUser,
            'title' => $article->title
        ]);
    }

    // Создание статьи
    public function create()
    {
        // Проверка: только авторизованные
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? null;
            $text = $_POST['text'] ?? null;
            $author_id = $_SESSION['user']['id'];

            Article::create($title, $text, $author_id);

            header('Location: /articles');
            exit;
        }

        View::render('articles/create.php', [
            'title' => 'Создать статью'
        ]);
    }

    // Редактирование статьи
    public function edit(int $id)
    {
        // Проверка: только авторизованные
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $article = Article::getById($id);

        if (!$article) {
            echo "Статья не найдена";
            return;
        }

        // Проверка: только автор может редактировать
        if ($article->author_id !== $_SESSION['user']['id']) {
            echo "У вас нет прав на редактирование этой статьи";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? null;
            $text = $_POST['text'] ?? null;

            Article::update($id, $title, $text);

            header("Location: /article/$id");
            exit;
        }

        View::render('articles/edit.php', [
            'article' => $article,
            'title' => 'Редактирование статьи'
        ]);
    }
}