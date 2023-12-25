<?php

use CatPaw\Web\Attributes\ProducesItem;
use CatPaw\Web\Attributes\Session;

use const CatPaw\Web\TEXT_PLAIN;

return [
    function(#[Session] &$session) {
        if (!($session['initialized'] ?? false)) {
            $session['initialized'] = time();
            return 'a';
        }
    },
    #[ProducesItem('string', TEXT_PLAIN, 'a')]
    function() {
        return 'b!';
    },
];