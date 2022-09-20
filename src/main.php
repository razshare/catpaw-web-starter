<?php

use CatPaw\Web\Attributes\Example;
use CatPaw\Web\Attributes\Param;
use CatPaw\Web\Attributes\ProducedResponse;
use CatPaw\Web\Attributes\Produces;
use CatPaw\Web\Attributes\StartWebServer;
use CatPaw\Web\Services\OpenAPIService;
use CatPaw\Web\Utilities\Route;

#[StartWebServer]
function main() {
    Route::get(
        '/test/{value}',
        #[Produces("text/plain", new ProducedResponse(example:[
            "test" => "test"
        ]))]
        function(
            #[Example('this is an example value')] #[Param] string $value
        ) {
            return "this is a test and the value is: $value";
        }
    );
    


    Route::get("/openapi", fn(OpenAPIService $oa) => $oa->getData());
    echo Route::describe().PHP_EOL;
}