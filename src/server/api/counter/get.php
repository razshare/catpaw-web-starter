<?php
use CatPaw\Web\Interfaces\SessionInterface;
return static function(SessionInterface $session) {
    return $session->ref('counter', 0);
};