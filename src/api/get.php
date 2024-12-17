<?php
use CatPaw\Document\Interfaces\DocumentInterface;
use CatPaw\Web\Query;

return fn (DocumentInterface $doc, Query $query) => $doc->render('welcome', $query);