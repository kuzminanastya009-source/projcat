<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'CatVerse' ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        /* 1. Убираем отступы браузера */
        html, body { margin: 0; padding: 0; height: 100%; }
        * { box-sizing: border-box; }

        body {
            background: #FFF0F5;
            color: #1a1a1a;
            font-family: 'Segoe UI', sans-serif;
        }

        /* 2. Стили шапки */
        header {
            background: #1a1a1a;
            padding: 15px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: #fff;
            font-size: 24px;
            font-weight: 800;
            text-decoration: none;
            letter-spacing: 1px;
        }

        .logo:hover { color: #ffd1dc; }

        /* 3. Меню для ПК (в строку) */
        .desktop-nav {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .desktop-nav a {
            color: #ccc;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .desktop-nav a:hover { color: #ffd1dc; }

        .btn-cabinet {
            background: #ffd1dc !important;
            color: #1a1a1a !important;
            padding: 8px 16px !important;
            border-radius: 20px !important;
            font-weight: bold !important;
        }

        .btn-cabinet:hover { background: #ff9eb5 !important; }

        /* 4. Мобильное меню (СКРЫТО ПО УМОЛЧАНИЮ) */
        .mobile-nav {
            display: none !important; /* !important гарантирует, что оно не будет видно */
            background: #2a2a2a;
            padding: 20px;
            text-align: center;
        }
        
        .mobile-nav.active {
            display: block !important; /* Показываем только если добавлен класс active */
        }

        .mobile-nav a {
            display: block;
            color: #fff;
            padding: 10px 0;
            text-decoration: none;
            border-bottom: 1px solid #444;
        }

        .mobile-menu-btn {
            display: none; /* Кнопка гамбургер скрыта на ПК */
            background: none;
            border: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
        }

        /* 5. Адаптивность для телефонов */
        @media (max-width: 768px) {
            .desktop-nav { display: none; } /* Скрываем меню ПК */
            .mobile-menu-btn { display: block; } /* Показываем гамбургер */
        }
    </style>
</head>
<body>

<header>
    <div class="header-container">
        <a href="/" class="logo"> CATVERSE</a>

        <!-- Меню для ПК -->
        <nav class="desktop-nav">
            <a href="/">Главная</a>
            <a href="/articles">Статьи</a>
            <a href="/cats">Коты</a>
            
          <?php if (!empty($_SESSION['user'])): ?>
    <span style="color:#fff">Привет, <?= htmlspecialchars($_SESSION['user']['nickname']) ?></span>
    <a href="/cabinet" class="btn-cabinet">Кабинет</a>
    <a href="/logout" style="color:#999; font-size: 0.9em;">Выйти</a>
<?php else: ?>
    <!-- ✅ Убрали auth/ из ссылок -->
    <a href="/login">Войти</a>
    <a href="/register">Регистрация</a>
<?php endif; ?>
        </nav>

        <!-- Кнопка для мобильных -->
        <button class="mobile-menu-btn" onclick="document.querySelector('.mobile-nav').classList.toggle('active')">☰</button>
    </div>
    
    <!-- Меню для Мобильных (Скрыто на ПК) -->
    <nav class="mobile-nav">
    <a href="/">Главная</a>
    <a href="/articles">Статьи</a>
    <a href="/cats">Коты</a>
    <?php if (!empty($_SESSION['user'])): ?>
        <a href="/cabinet">Личный кабинет</a>
        <a href="/logout">Выйти</a>
    <?php else: ?>
        <!-- ✅ Убрали auth/ -->
        <a href="/login">Войти</a>
        <a href="/register">Регистрация</a>
    <?php endif; ?>
</nav>
</header>

<main style="max-width: 1200px; margin: 0 auto; padding: 20px;">