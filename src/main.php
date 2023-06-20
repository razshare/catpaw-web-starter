<?php

use CatPaw\Web\Attributes\IgnoreOpenAPI;
use CatPaw\Web\Server;
use CatPaw\Web\Services\OpenAPIService;

function main():void {
    echo json_encode(['test' => $_ENV['test']]).PHP_EOL;
    $server = Server::create();
    $server->router->get('/openapi', #[IgnoreOpenAPI] fn (OpenAPIService $oa) => $oa->getData());
    $server->start();
}