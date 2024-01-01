<?php

use CatPaw\Web\Attributes\IgnoreOpenAPI;
use CatPaw\Web\Server;
use CatPaw\Web\Services\OpenApiService;

function main():void {
    $server = Server::create(interfaces:"0.0.0.0:5757");
    $server->router->get('/openapi', #[IgnoreOpenAPI] fn (OpenApiService $oa) => $oa->getData());
    $server->start();
}