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
function main(OpenApiService $oa) {
    return anyError(function() use ($oa) {
        $oa->setTitle("My api");
        $oa->setVersion("1.0.0");

        $server = Server::create(
            interface: env('interface'),
            www: env('www'),
            api: env('api'),
            apiPrefix: env('apiPrefix'),
        )
            ->try($error)
        or yield $error;

        $server
            ->router
            ->get(path:'/openapi', function: #[IgnoreOpenApi] static fn () => $oa->getData())
            ->try($error)
            or yield $error;

        $server
            ->start()
            ->await()
            ->try($error)
            or yield $error;
    });
}
