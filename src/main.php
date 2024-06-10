<?php

use function CatPaw\Core\anyError;
use function CatPaw\Core\asFileName;
use function CatPaw\Core\env;
use CatPaw\Core\Unsafe;

use const CatPaw\Web\APPLICATION_JSON;
use CatPaw\Web\Attributes\IgnoreOpenApi;
use CatPaw\Web\Interfaces\OpenApiInterface;
use CatPaw\Web\Interfaces\ResponseModifier;
use CatPaw\Web\Interfaces\RouterInterface;
use CatPaw\Web\Interfaces\ServerInterface;
use CatPaw\Web\Interfaces\ViewEngineInterface;

use function CatPaw\Web\loadComponentFromFile;
use function CatPaw\Web\success;

#[IgnoreOpenApi]
function openapi(OpenApiInterface $openApi):ResponseModifier {
    return success($openApi->getData())->as(APPLICATION_JSON);
}

/**
 * @return Unsafe<void>
 */
function main(
    ServerInterface $server,
    RouterInterface $router,
    OpenApiInterface $openApi,
    ViewEngineInterface $viewEngine,
): Unsafe {
    return anyError(function() use ($server, $router, $openApi, $viewEngine) {
        $viewEngine->withTemporaryDirectory(asFileName(__DIR__, '.tmp'));
        $openApi->setTitle("My Api");
        $openApi->setVersion("1.0.0");

        loadComponentFromFile('index', [], asFileName(__DIR__, 'index.latte'))->try();

        $router->get('/openapi', openapi(...))->try();

        $server
            ->withInterface(env('interface'))
            ->withStaticsLocation(env('staticsLocation'))
            ->withApiLocation(env('apiLocation'))
            ->withApiPrefix('/')
            ->start()
            ->try();
    });
}
