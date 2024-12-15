<?php
use CatPaw\Document\Interfaces\DocumentInterface;
use CatPaw\Web\Attributes\Query;

return fn (DocumentInterface $doc, #[Query] string $name = '') => $doc->run(
    'welcome',
    ['name' => $name],
);