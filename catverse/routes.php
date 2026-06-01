<?php

use Src\Controllers\MainController;
use Src\Controllers\ArticleController;
use Src\Controllers\CatController;
use Src\Controllers\UserController;

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

$routes = [
    '~^$~' => [\Src\Controllers\CatController::class, 'index'],
    '~^cats$~' => [\Src\Controllers\CatController::class, 'index'],
    '~^cat/(\d+)$~' => [\Src\Controllers\CatController::class, 'show'],
    '~^cat/(\d+)/edit$~' => [\Src\Controllers\CatController::class, 'edit'],
    '~^cat/(\d+)/delete$~' => [\Src\Controllers\CatController::class, 'delete'],
    '~^cat/(\d+)/age$~' => [\Src\Controllers\CatController::class, 'age'],
    '~^cat/(\d+)/favorite$~' => [\Src\Controllers\CatController::class, 'favorite'],
    '~^cat/(\d+)/like$~' => [\Src\Controllers\CatController::class, 'like'],
    '~^cat/(\d+)/comment$~' => [\Src\Controllers\CatController::class, 'comment'],
    '~^cats/create$~' => [\Src\Controllers\CatController::class, 'create'],
    
    //  Авторизация (без auth/)
    '~^login$~' => [\Src\Controllers\AuthController::class, 'login'],
    '~^register$~' => [\Src\Controllers\AuthController::class, 'register'],
    '~^logout$~' => [\Src\Controllers\AuthController::class, 'logout'],
    
    //  Статьи
    '~^articles$~' => [\Src\Controllers\ArticleController::class, 'index'],
    '~^article/(\d+)$~' => [\Src\Controllers\ArticleController::class, 'show'],
    '~^articles/create$~' => [\Src\Controllers\ArticleController::class, 'create'],
    '~^article/(\d+)/edit$~' => [\Src\Controllers\ArticleController::class, 'edit'],
    
    '~^cabinet$~' => [\Src\Controllers\UserController::class, 'cabinet'],
    '~^favorites$~' => [\Src\Controllers\CatController::class, 'favorites'],
'~^hello/([a-zA-Zа-яА-Я0-9]+)$~' => [\Src\Controllers\MainController::class, 'hello'],
'~^bye/([a-zA-Zа-яА-Я0-9]+)$~' => [\Src\Controllers\MainController::class, 'sayBye'],
];

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

foreach ($routes as $pattern => $controllerData) {
    if (preg_match($pattern, $uri, $matches)) {
        array_shift($matches);
        
        if ($controllerData instanceof Closure) {
            call_user_func_array($controllerData, $matches);
        } else {
            $controller = new $controllerData[0];
            $method = $controllerData[1];
            $controller->$method(...$matches);
        }
        exit;
    }
}

echo "404 — страница не найдена";