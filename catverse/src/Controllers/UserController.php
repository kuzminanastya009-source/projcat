<?php

namespace Src\Controllers;

use Src\View\View;

class UserController
{
    public function cabinet()
    {
        $this->ensureAuth();
        
        $user = $_SESSION['user'];
        $userId = $user['id'];
        
        $db = \Src\Services\Db::getConnection();
        
        // Получаем статьи текущего пользователя
        $stmt = $db->prepare("
            SELECT * FROM articles 
            WHERE author_id = ? 
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        $articles = $stmt->fetchAll(\PDO::FETCH_OBJ);
        
        // Получаем котов текущего пользователя
        $stmt = $db->prepare("
            SELECT * FROM cats 
            WHERE author_id = ? 
            ORDER BY id DESC
        ");
        $stmt->execute([$userId]);
        $cats = $stmt->fetchAll(\PDO::FETCH_OBJ);
        
        \Src\View\View::render('user/cabinet.php', [
            'user' => $user,
            'articles' => $articles,
            'cats' => $cats,
            'title' => 'Личный кабинет'
        ]);
    }
    
    /**
     * Проверка авторизации пользователя
     */
    private function ensureAuth()
    {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }
}