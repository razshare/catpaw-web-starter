<?php

use CatPaw\Web\Attributes\StartWebServer;
use CatPaw\Web\Utilities\Route;

#[StartWebServer]
function main() {
    Route::get("/hello", fn() => "hello world");
    echo Route::describe().PHP_EOL;
}
