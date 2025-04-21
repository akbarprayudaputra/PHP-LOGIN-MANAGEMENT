<?php

namespace Akbarprayuda\PhpMvc\Config;

class View {
    public static function render(string $view, $model): void
    {
        require __DIR__ ."/../View/" . $view . ".php";
    }
}