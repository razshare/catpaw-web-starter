<?php

use function CatPaw\Core\anyError;
use function CatPaw\Core\env;
use CatPaw\Core\Unsafe;

use const CatPaw\Web\APPLICATION_JSON;
use CatPaw\Web\Attributes\IgnoreOpenApi;
use CatPaw\Web\Server;
use CatPaw\Web\Services\OpenApiService;

use function CatPaw\Web\success;

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
            ->get(path:'/openapi', function: #[IgnoreOpenApi] static fn () => success($oa->getData())->as(APPLICATION_JSON))
            ->try($error)
            or yield $error;

        $server
            ->start()
            ->await()
            ->try($error)
            or yield $error;
    });
}
