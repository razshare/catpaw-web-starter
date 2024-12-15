<?php
use CatPaw\Document\Interfaces\DocumentInterface;
use CatPaw\Web\Query;

return fn (DocumentInterface $doc, Query $name) => $doc->run(
    'welcome',
    ['name' => $name],
);