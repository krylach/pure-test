<?php

App\Libs\Route::get("/", "Controller::index");
App\Libs\Route::post("/handler", "Controller::handler");


App\Libs\Kernel::error();
