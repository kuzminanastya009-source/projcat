<?php

namespace Src\Controllers;

use Src\View\View;

class MainController
{
    public function index()
    {
        View::render('main/hello.php', ['title' => 'Главная']);
    }

    public function hello(string $name)
    {
        View::render('main/hello.php', [
            'name' => $name,
            'title' => 'Страница приветствия'
        ]);
    }

    // Оставляем ТОЛЬКО ОДИН метод sayBye
    public function sayBye(string $name)
    {
        View::render('main/bye.php', [
            'name' => $name,
            'title' => 'Прощание'
        ]);
    }
}