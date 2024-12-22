<?php
use function CatPaw\Core\env;
use CatPaw\Core\None;
use CatPaw\Core\Result;
use CatPaw\Web\Interfaces\ServerInterface;

/**
 * Application entry point.
 * @param  ServerInterface $server
 * @return Result<None>
 */
function main(ServerInterface $server): Result {
    return $server
        ->withInterface(env('interface'))
        ->withApiLocation(env('apiLocation'))
        ->withStaticsLocation(env('staticsLocation'))
        ->start();
}
