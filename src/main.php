<?php
use function CatPaw\Core\env;
use function CatPaw\Core\error;
use CatPaw\Core\None;
use CatPaw\Core\Result;
use const CatPaw\Web\APPLICATION_JSON;
use CatPaw\Web\Attributes\IgnoreOpenApi;
use CatPaw\Web\Interfaces\OpenApiInterface;
use CatPaw\Web\Interfaces\ResponseModifier;
use CatPaw\Web\Interfaces\RouterInterface;
use CatPaw\Web\Interfaces\ServerInterface;
use function CatPaw\Web\success;

#[IgnoreOpenApi]
function openapi(OpenApiInterface $openApi):ResponseModifier {
    return success($openApi->data())->as(APPLICATION_JSON);
}

/**
 * Application entry point.
 * @param  ServerInterface  $server
 * @param  RouterInterface  $router
 * @param  OpenApiInterface $openApi
 * @return Result<None>
 */
function main(
    ServerInterface $server,
    RouterInterface $router,
    OpenApiInterface $openApi,
): Result {
    $openApi->withTitle("My Api");
    $openApi->withVersion("1.0.0");
    
    $router->get('/openapi', openapi(...))->unwrap($error);
    if ($error) {
        return error($error);
    }

    return $server
        ->withInterface(env('interface'))
        ->withStaticsLocation(env('staticsLocation'))
        ->withApiLocation(env('apiLocation'))
        ->start();
}
