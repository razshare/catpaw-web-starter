<?php

use CatPaw\Web\Attributes\Session;

return [
    function(#[Session] &$session) {
        if (!($session['initialized'] ?? false)) {
            $session['initialized'] = time();
            return "a";
        }
    },
    function() {
        return "b!";
    },
];