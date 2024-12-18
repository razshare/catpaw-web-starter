<?php
use CatPaw\Web\Interfaces\RenderInterface;
?>

<?php return static function(RenderInterface $render, string $name = 'world') { ?>
    <?php $render->start() ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome</title>
        <link rel="stylesheet" href="/main.css">
    </head>
    <body>
        <div class="
            fixed left-0 right-0 top-0 bottom-0 grid
            justify-center content-center
            bg-gray-900
            text-8xl
        ">
            <h3 class="text-orange-600">
                Hello, <?=$name?>!
            </h3>
        </div>
    </body>
    </html>
<?php } ?>