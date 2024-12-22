<?php

use function CatPaw\Core\asFileName;
use CatPaw\Core\Directory;
use function CatPaw\Core\env;
use function CatPaw\Core\error;

use function CatPaw\Core\execute;
use CatPaw\Core\None;
use CatPaw\Core\Result;
use CatPaw\Web\Interfaces\ServerInterface;

/**
 * Application entry point.
 * @param  ServerInterface $server
 * @return Result<None>
 */
function main(ServerInterface $server): Result {
    // Create assets.
    Directory::create(asFileName(__DIR__, '../statics/assets')->absolute())->unwrap($error);
    if ($error) {
        return error($error);
    }

    // Build tailwind.
    $input  = asFileName(__DIR__, 'main.css')->absolute();
    $output = asFileName(__DIR__, '../statics/assets/main.css')->absolute();
    execute("bunx tailwindcss -i $input -o $output")->unwrap($error);
    if ($error) {
        return error($error);
    }
    
    return $server
        ->withInterface(env('interface'))
        ->withApiLocation(env('apiLocation'))
        ->withStaticsLocation(env('staticsLocation'))
        ->start();
}
