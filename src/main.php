<?php

use CatPaw\Core\Unsafe;
use CatPaw\Web\Attributes\IgnoreOpenApi;
use CatPaw\Web\Server;
use CatPaw\Web\Services\OpenApiService;
use CatPaw\Web\Services\TwigService;
use function CatPaw\Core\anyError;
use function CatPaw\Core\env;
use function CatPaw\Web\success;
use const CatPaw\Web\__APPLICATION_JSON;

/**
 * @return Unsafe<void>
 */
function main(OpenApiService $oa, TwigService $twigService): Unsafe {
    return anyError(function() use ($oa, $twigService) {
        $oa->setTitle("My api");
        $oa->setVersion("1.0.0");

        $server = Server::create(
            interface: env('interface'),
            api      : env('api'),
            www      : env('www'),
            apiPrefix: env('apiPrefix'),
        )
            ->try($error)
            or yield $error;
        
            
        $twigService->load($server->api)->try($error) or yield $error;

        $server
            ->router
            ->get(path:'/openapi', function: #[IgnoreOpenApi] static fn () => success($oa->getData())->as(__APPLICATION_JSON))
            ->try($error)
            or yield $error;

        $server
            ->start()
            ->await()
            ->try($error)
            or yield $error;
    });
}
