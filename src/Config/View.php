<?php

namespace Akbarprayuda\PhpMvc\Config;

class View
{
    public static function render(string $view, array $model): void
    {
        require __DIR__ . "/../View/template/header.php";
        require __DIR__ . "/../View/" . $view . ".php";
        require __DIR__ . "/../View/template/footer.php";
    }

    public static function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}
