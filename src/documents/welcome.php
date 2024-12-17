<?php
use CatPaw\Web\Query;
$GET = fn (Query $query) => $query;
?>

<?php return function(string $name = 'world') { ?>
    <h3>Hello <?=$name?></h3>
<?php } ?>