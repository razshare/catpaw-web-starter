<?php

use function CatPaw\Core\anyError;
use function CatPaw\Core\asFileName;
use function CatPaw\Core\env;
use CatPaw\Core\Unsafe;

use const CatPaw\Web\APPLICATION_JSON;
use CatPaw\Web\Attributes\IgnoreOpenApi;
use CatPaw\Web\Interfaces\ResponseModifier;
use function CatPaw\Web\loadComponent;
use CatPaw\Web\Server;
use CatPaw\Web\Services\OpenApiService;

use function CatPaw\Web\success;

#[IgnoreOpenApi]
function openapi(OpenApiService $oa):ResponseModifier {
    return success($oa->getData())->as(APPLICATION_JSON);
}

/**
 * @return Unsafe<void>
 */
function main(OpenApiService $oa): Unsafe {
    return anyError(function() use ($oa) {
        $oa->setTitle("My Api");
        $oa->setVersion("1.0.0");
        
        loadComponent(asFileName(__DIR__, 'index.twig'), 'index')->try();

        $server = Server::get()
            ->withInterface(env('interface'))
            ->withStaticsLocation(env('staticsLocation'))
            ->withApiLocation(env('apiLocation'))
            ->withApiPrefix('/');

        $server->router->get('/openapi', openapi(...))->try();

        $server->start()->try();
    });
}
