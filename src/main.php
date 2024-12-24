<?php
use CatPaw\Core\Container;
use CatPaw\Core\Directory;
use function CatPaw\Core\env;
use function CatPaw\Core\error;
use CatPaw\Core\FileName;
use CatPaw\Core\None;
use CatPaw\Core\Process;
use CatPaw\Core\Result;
use CatPaw\Web\Interfaces\ServerInterface;
use Smarty\Smarty;

/**
 * Application entry point.
 * @param  ServerInterface $server
 * @return Result<None>
 */
function main(ServerInterface $server): Result {
    if ('' === $smartyTemplateDirectory = env('smarty.template')) {
        return error("Smarty template directory not defined in environment variables (`smarty.template`).");
    }

    if ('' === $smartyConfigDirectory = env('smarty.config')) {
        return error("Smarty config directory not defined in environment variables (`smarty.config`).");
    }

    if ('' === $smartyCompileDirectory = env('smarty.compile')) {
        return error("Smarty compile directory not defined in environment variables (`smarty.compile`).");
    }

    if ('' === $smartyCacheDirectory = env('smarty.cache')) {
        return error("Smarty cache directory not defined in environment variables (`smarty.cache`).");
    }

    // Using Smarty as a template engine.
    $smarty = new Smarty;
    $smarty->setTemplateDir(FileName::create($smartyTemplateDirectory)->absolute());
    $smarty->setConfigDir(FileName::create($smartyConfigDirectory)->absolute());
    $smarty->setCompileDir(FileName::create($smartyCompileDirectory)->absolute());
    $smarty->setCacheDir(FileName::create($smartyCacheDirectory)->absolute());

    $errors = [];
    $smarty->testInstall($errors);
    if ($errors) {
        $errorMessage = '';
        foreach ($errors as $error) {
            $errorMessage .= "$error\n";
        }
        return error($errorMessage);
    }

    Container::provide(Smarty::class, $smarty);

    // Create assets.
    Directory::create(FileName::create(__DIR__, '../statics/assets')->absolute())->unwrap($error);
    if ($error) {
        return error($error);
    }

    // Build tailwind.
    if ('' === $tailwindInput = env('tailwind.input')) {
        return error('Tailwind input not provided.');
    }

    if ('' === $tailwindOutput = env('tailwind.output')) {
        return error('Tailwind output not provided.');
    }

    $input  = FileName::create($tailwindInput)->absolute();
    $output = FileName::create($tailwindOutput)->absolute();
    Process::execute("bunx tailwindcss -i $input -o $output")->unwrap($error);
    if ($error) {
        return error($error);
    }

    // Make sure api and statics are defined.
    if ('' === $apiLocation = env('api')) {
        return error('Api location not provided.');
    }

    if ('' === $staticsLocation = env('statics')) {
        return error('Statics location not provided.');
    }

    return $server
        ->withInterface(env('interface'))
        ->withApiLocation(FileName::create($apiLocation)->absolute())
        ->withStaticsLocation(FileName::create($staticsLocation)->absolute())
        ->start();
}
