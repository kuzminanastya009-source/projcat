<?php

namespace Src\View;

class View
{
    public static function render(string $template, array $params = [])
    {
        extract($params);

        include __DIR__ . '/../Templates/header.php';
        include __DIR__ . '/../View/' . $template;
        include __DIR__ . '/../Templates/footer.php';
    }
}
