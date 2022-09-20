<?php

use CatPaw\Web\Attributes\StartWebServer;
use CatPaw\Web\Services\OpenAPIService;
use CatPaw\Web\Utilities\Route;

#[StartWebServer]
function main() {
    Route::get("/openapi", fn(OpenAPIService $oa) => $oa->getData());
    echo Route::describe().PHP_EOL;
}