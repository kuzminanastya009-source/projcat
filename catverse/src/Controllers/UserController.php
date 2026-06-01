<?php

namespace Src\Controllers;

use Src\View\View;

class UserController
{
    public function cabinet()
    {
        // Если не вошел — выкидываем на логин
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $user = $_SESSION['user'];
        
        View::render('user/cabinet.php', [
            'user' => $user,
            'title' => 'Личный кабинет'
        ]);
    }
}