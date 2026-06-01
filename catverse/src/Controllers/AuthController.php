<?php

namespace Src\Controllers;

use Src\Services\Db;
use Src\View\View;

class AuthController
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nickname = trim($_POST['nickname']);
            $email = trim($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $db = Db::getConnection();
            $stmt = $db->prepare("INSERT INTO users (nickname, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$nickname, $email, $password]);

            header('Location: /login');
            exit;
        }

        View::render('auth/register.php', ['title' => 'Регистрация']);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $db = Db::getConnection();
            $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetchObject();

            if ($user && password_verify($password, $user->password)) {
                $_SESSION['user'] = [
                    'id' => $user->id,
                    'nickname' => $user->nickname,
                    'role' => $user->role
                ];
                header('Location: /cats');
                exit;
            } else {
                $error = 'Неверный email или пароль';
            }
        }

        View::render('auth/login.php', ['title' => 'Вход', 'error' => $error ?? null]);
    }

    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
