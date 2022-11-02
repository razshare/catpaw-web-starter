<?php

use CatPaw\Environment\Attributes\Environment;
use CatPaw\Web\Attributes\StartWebServer;
use CatPaw\Web\Services\OpenAPIService;
use CatPaw\Web\Utilities\Route;

#[Environment]
#[StartWebServer]
function main() {
    Route::get("/openapi", fn (OpenAPIService $oa) => $oa->getData());
    echo Route::describe().PHP_EOL;
}