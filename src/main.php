<?php

use CatPaw\Web\Attributes\IgnoreOpenAPI;
use CatPaw\Web\Server;
use CatPaw\Web\Services\OpenAPIService;

function main():void {
    Route::get("/openapi", #[IgnoreOpenAPI] fn (OpenAPIService $oa) => $oa->getData());
    Server::create()->start();
}