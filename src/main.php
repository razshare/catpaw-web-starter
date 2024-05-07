<?php

use function CatPaw\Core\anyError;
use function CatPaw\Core\asFileName;
use function CatPaw\Core\env;
use CatPaw\Core\Unsafe;
use const CatPaw\Web\APPLICATION_JSON;
use CatPaw\Web\Attributes\IgnoreOpenApi;
use CatPaw\Web\Server;
use CatPaw\Web\Services\HandlebarsService;
use CatPaw\Web\Services\OpenApiService;
use function CatPaw\Web\success;

#[IgnoreOpenApi]
function openapi(OpenApiService $oa) {
    return success($oa->getData())->as(APPLICATION_JSON);
}

/**
 * @return Unsafe<void>
 */
function main(OpenApiService $oa, HandlebarsService $handlebars): Unsafe {
    return anyError(function() use ($oa, $handlebars) {
        $handlebars->withTemporaryDirectory(asFileName(__DIR__, './temp'));

        $oa->setTitle("My api");
        $oa->setVersion("1.0.0");

        $server = Server::get()
            ->withInterface(env('interface'))
            ->withApiLocation(env('apiLocation'))
            ->withStaticsLocation(env('staticsLocation'));

        $server->router->get('/openapi', openapi(...))->try();

        $server->start()->try();
    });
}
