<?php

use CatPaw\Web\Attributes\ProducedResponse;
use CatPaw\Web\Attributes\Produces;
use CatPaw\Web\Attributes\StartWebServer;
use CatPaw\Web\Services\OpenAPIService;
use CatPaw\Web\Utilities\Route;

#[StartWebServer]
function main() {
    Route::get(
        '/test',
        #[Produces(
            new ProducedResponse(
                type: 'application/json',
                status: 200,
                schema: [
                    "user" => [[        // <=== note the double wrapping
                        "email"    => "string",
                        "name"     => "string",
                        "articles" => [[        // <=== double wrapping again to indicate an array of articles
                            "title"       => "string",
                            "description" => "string",
                        ]]
                    ]]
                ]
            )
        )]
        function() {
            return [
                [
                    "email"    => "some@email.com",
                    "name"     => "name1",
                    "articles" => [],
                ],
                [
                    "email"    => "someother@email.com",
                    "name"     => "name2",
                    "articles" => [
                        [
                            "title"       => "article title 1",
                            "description" => "article description 1",
                        ],
                        [
                            "title"       => "article title 2",
                            "description" => "article description 2",
                        ],
                    ],
                ],
            ];
        }
    );
    


    Route::get("/openapi", fn(OpenAPIService $oa) => $oa->getData());
    echo Route::describe().PHP_EOL;
}