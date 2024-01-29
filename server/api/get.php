<?php

use function CatPaw\Core\asFileName;
use const CatPaw\Web\__APPLICATION_JSON;
use const CatPaw\Web\__OK;
use const CatPaw\Web\__TEXT_HTML;
use CatPaw\Web\Accepts;
use CatPaw\Web\Attributes\OperationId;
use CatPaw\Web\Attributes\Produces;
use CatPaw\Web\Attributes\ProducesPage;
use CatPaw\Web\Attributes\Summary;
use function CatPaw\Web\failure;
use function CatPaw\Web\success;
use function CatPaw\Web\twig;

class Quote {
    public function __construct(
        public string $content,
    ) {
    }
}

return
#[OperationId('findQuotes')]
#[ProducesPage(
    status: __OK,
    contentType: __APPLICATION_JSON,
    description: 'on success',
    className: Quote::class,
    example: new Quote(content: '"Cats are connoisseurs of comfort." - James Herriot'),
)]
#[Produces(__OK, __TEXT_HTML, 'Html page', 'string')]
#[Summary("What even is a cat?")]
function(Accepts $accepts) {
    static $lines = [
        '"Cats are connoisseurs of comfort." - James Herriot',
        '"Just watching my cats can make me happy." - Paula Cole',
        '"I\'m not sure why I like cats so much. I mean, they\'re really cute obviously. They are both wild and domestic at the same time." - Michael Showalter',
        '"You can not look at a sleeping cat and feel tense." - Jane Pauley',
        '"The phrase \'domestic cat\' is an oxymoron." - George Will',
        '"One cat just leads to another." - Ernest Hemingway',
    ];

    $quote = $lines[array_rand($lines)];
    
    return match (true) {
        $accepts->json() => success(new Quote(content: $quote))->as(__APPLICATION_JSON)->item(),
        $accepts->html() => twig(asFileName(__DIR__, 'get'))->setProperty('quote', $quote)->render(),
        default          => failure("Cannot serve {$accepts}."),
    };
};