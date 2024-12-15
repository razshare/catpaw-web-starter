<?php
use CatPaw\Web\Query;
$name ??= input(Query::class);

if (!mounted()) {
    return;
}

$greeting = match (empty($name->text())) {
    true  => 'Welcome!',
    false => "Hello $name!",
};
?>

<h3><?= $greeting ?></h3>