<?php

$kernel = new App\Libs\Kernel();

function request() {
    return new App\Libs\Request();
}

function server() {
    $handledServerArray = new stdClass();
    foreach ($_SERVER as $key => $value) {
        $key = mb_strtolower($key);
        $handledServerArray->$key = $value;
    }

    return $handledServerArray;
}

function response()
{
    return new App\Libs\Response;
}