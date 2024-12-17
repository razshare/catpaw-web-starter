<?php expose('/{name}') ?>
<?php function mount(string $name = 'world'):void { ?>
    <h3>Hello <?=$name?></h3>
<?php } ?>