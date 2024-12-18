<?php
use function CatPaw\Core\asFileName;
use function CatPaw\Core\env;
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
    $input  = asFileName(__DIR__, 'main.css')->absolute();
    $output = asFileName(__DIR__, '../statics/main.css')->absolute();

    execute("asd tailwindcss -i $input -o $output")->logError();

    return $server
        ->withInterface(env('interface'))
        ->withStaticsLocation(env('staticsLocation'))
        ->withApiLocation(env('apiLocation'))
        ->start();
}
