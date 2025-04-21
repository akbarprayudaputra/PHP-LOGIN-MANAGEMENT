<?php

namespace Akbarprayuda\PhpMvc\Controller;

use Akbarprayuda\PhpMvc\Config\View;

class HomeController {
    public function index(): void {
        $model = [
            "title"=> "Home Page",
            "content"=> str_repeat("Lorem ipsum dolor sit amet, consectetur adipiscing elit. ", 2),
        ];
        
        View::render("index", $model);
    }
}