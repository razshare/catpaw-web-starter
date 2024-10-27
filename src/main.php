<?php
use function CatPaw\Core\env;
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

function main(
    ServerInterface $server,
    RouterInterface $router,
    OpenApiInterface $openApi,
): void {
    $openApi->withTitle("My Api");
    $openApi->withVersion("1.0.0");
    $router->get('/openapi', openapi(...))->try();
    $server
        ->withInterface(env('interface'))
        ->withStaticsLocation(env('staticsLocation'))
        ->withApiLocation(env('apiLocation'))
        ->withApiPrefix('/')
        ->start()
        ->try();
}
