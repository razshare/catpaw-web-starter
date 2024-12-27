<?php
use CatPaw\Web\Interfaces\SessionInterface;

return static function(SessionInterface $session) {
    $counter = &$session->ref('counter', 0);
    $counter--;
};