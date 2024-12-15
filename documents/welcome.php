<?php
$name ??= input();
$greeting = match (empty($name)) {
    true  => 'Welcome.',
    false => "Hello $name!",
};
?>

<h3><?= $greeting ?></h3>