<?php
use CatPaw\Web\Interfaces\SessionInterface;
return static fn (SessionInterface $session) => $session->ref('counter', 0);