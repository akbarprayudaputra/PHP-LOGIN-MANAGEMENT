<?php

namespace Akbarprayuda\PhpMvc\Config;

interface Middleware {
    public function before(): void;
}