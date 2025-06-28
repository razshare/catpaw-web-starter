<?php
use function CatPaw\Core\env;
use function CatPaw\Core\error;
use CatPaw\Core\FileName;
use CatPaw\Core\Interfaces\EnvironmentInterface;
use CatPaw\Core\None;
use CatPaw\Core\Result;
use CatPaw\Web\Interfaces\ResponseModifierInterface;
use CatPaw\Web\Interfaces\RouterInterface;
use CatPaw\Web\Interfaces\ServerInterface;
use function CatPaw\Web\redirect;

/**
 * Redirects to /api/Counter/increase
 * @return ResponseModifierInterface
 */
function redirectToIncrease():ResponseModifierInterface {
    return redirect("/api/counter/increase");
}

/**
 * Application entry point.
 * @param  ServerInterface $server
 * @return Result<None>
 */
function main(
    ServerInterface $server,
    EnvironmentInterface $env,
    RouterInterface $router,
): Result {
    $env->load()->unwrap($error);
    if ($error) {
        return error($error);
    }

    $router->addHandler("GET", "/", redirectToIncrease(...))->unwrap($error);
    if ($error) {
        return error($error);
    }

    return $server
        ->withInterface(env('server.interface'))
        ->withStaticsLocation(FileName::create(env('statics.location')))
        ->withApiLocation(FileName::create(env('api.location')))
        ->withApiPrefix(FileName::create(env('api.prefix')))
        ->start();
}
