<?php

use CatPaw\Environment\Attributes\Environment;
use CatPaw\Web\Server;
use CatPaw\Web\Services\OpenAPIService;
use CatPaw\Web\Utilities\Route;

#[Environment]
function main():void {
    Route::get("/openapi", fn (OpenAPIService $oa) => $oa->getData());
    Server::create()->start();
}