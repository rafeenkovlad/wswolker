<?php

namespace App\Workerman\Config;

use Symfony\Component\Dotenv\Dotenv;

class ENV
{
    private function __construct()
    {

    }

    public static function init() {
        $dotenv = new Dotenv();
        $dotenv->load('./.env');
    }
}