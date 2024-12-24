<?php
use CatPaw\Core\Container;
use CatPaw\Core\Directory;
use function CatPaw\Core\env;
use function CatPaw\Core\error;
use CatPaw\Core\FileName;
use CatPaw\Core\None;
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

    $smartyTemplateDirectory = FileName::create($smartyTemplateDirectory)->absolute();
    $smartyConfigDirectory   = FileName::create($smartyConfigDirectory)->absolute();
    $smartyCacheDirectory    = FileName::create($smartyCacheDirectory)->absolute();
    $smartyCompileDirectory  = FileName::create($smartyCompileDirectory)->absolute();

    Directory::create($smartyCacheDirectory)->unwrap($error);
    if ($error) {
        return error($error);
    }
    
    Directory::create($smartyCompileDirectory)->unwrap($error);
    if ($error) {
        return error($error);
    }
    

    // Using Smarty as a template engine.
    $smarty = new Smarty;
    $smarty->setTemplateDir($smartyTemplateDirectory);
    $smarty->setConfigDir($smartyConfigDirectory);
    $smarty->setCompileDir($smartyCompileDirectory);
    $smarty->setCacheDir($smartyCacheDirectory);

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
