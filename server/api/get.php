<?php
use const CatPaw\Web\__APPLICATION_JSON;
use const CatPaw\Web\__OK;

use CatPaw\Web\Attributes\OperationId;
use CatPaw\Web\Attributes\ProducesPage;
use CatPaw\Web\Attributes\Summary;

use function CatPaw\Web\success;

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
#[Summary("What even is a cat?")]
function() {
    static $lines = [
        '"Cats are connoisseurs of comfort." - James Herriot',
        '"Just watching my cats can make me happy." - Paula Cole',
        '"I\'m not sure why I like cats so much. I mean, they\'re really cute obviously. They are both wild and domestic at the same time." - Michael Showalter',
        '"You can not look at a sleeping cat and feel tense." - Jane Pauley',
        '"The phrase \'domestic cat\' is an oxymoron." - George Will',
        '"One cat just leads to another." - Ernest Hemingway',
    ];

    return success(new Quote(content: $lines[array_rand($lines)]))->as(__APPLICATION_JSON)->item();
};