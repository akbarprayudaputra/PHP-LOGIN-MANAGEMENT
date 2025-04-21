<?php

namespace Akbarprayuda\PhpMvc\Controller;

use Akbarprayuda\PhpMvc\Config\View;

class HomeController
{
    public function index(): void
    {
        View::render("Home/index", [
            'title' => 'PHP Login Management'
        ]);
    }
}
