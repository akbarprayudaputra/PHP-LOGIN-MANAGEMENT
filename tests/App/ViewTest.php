<?php

namespace Akbarprayuda\PhpMvc\Tests\App;

use Akbarprayuda\PhpMvc\Config\View;
use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function testRender(): void
    {
        View::render("Home/index", [
            "title" => "PHP Login Management"
        ]);

        $this->expectOutputRegex("[PHP Login Management]");
        $this->expectOutputRegex("[html]");
        $this->expectOutputRegex("[Login]");
        $this->expectOutputRegex("[Login Management]");
        $this->expectOutputRegex("[Login]");
        $this->expectOutputRegex("[Register]");
    }
}
