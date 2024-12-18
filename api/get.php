<?php
use CatPaw\Web\QueryItem;
use function CatPaw\Web\render;
?>

<?php return static fn (QueryItem $name) => render(function() use ($name) { ?>
    <?php $name = $name->text() ?: 'world'; ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome</title>
        <link rel="stylesheet" href="/index.css">
    </head>
    <body>
        <div class="
            fixed left-0 right-0 top-0 bottom-0 grid
            justify-center content-center
            bg-gray-900
            text-8xl
        ">
            <h3 class="text-orange-600">
                Hello, <?=$name?>.
            </h3>
        </div>
    </body>
    </html>
<?php }) ?>