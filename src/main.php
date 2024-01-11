<?php

use function CatPaw\Core\anyError;
use function CatPaw\Core\env;

use CatPaw\Core\Unsafe;
use CatPaw\Web\Attributes\IgnoreOpenApi;
use CatPaw\Web\Server;
use CatPaw\Web\Services\OpenApiService;

/**
 * @return Unsafe<void>
 */
function main(OpenApiService $oa):Unsafe {
    $oa->setTitle("My api");
    $oa->setVersion("1.0.0");
    return anyError(
        $server = Server::create(
            interface: env('interface'),
            www: env('www'),
            api: env('api'),
            apiPrefix: env('apiPrefix'),
        ),
        $server
            ->value
            ->router
            ->get(
                path:'/openapi',
                function:
                #[IgnoreOpenApi]
                static fn () => $oa->getData(),
            ),
        $server->value->start()->await(),
    );
}