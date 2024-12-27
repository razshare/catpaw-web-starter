<?php
use function CatPaw\Core\env;
use CatPaw\Core\FileName;
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
        ->withInterface(env('server.interface'))
        ->withStaticsLocation(FileName::create(env('statics.location')))
        ->withApiLocation(FileName::create(env('api.location')))
        ->withApiPrefix(FileName::create(env('api.prefix')))
        ->start();
}
