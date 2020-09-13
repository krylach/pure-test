<?php

namespace App\Libs;

class Kernel {
    public static function error()
    {
        header("HTTP/1.0 404 Not Found");
    }
}
