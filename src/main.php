<?php

use CatPaw\Web\Attributes\IgnoreOpenAPI;
use CatPaw\Web\Server;
use CatPaw\Web\Services\OpenAPIService;

function main():void {
    $server = Server::create();
    $server->router->get("/openapi", #[IgnoreOpenAPI] fn (OpenAPIService $oa) => $oa->getData());
    $server->start();
}