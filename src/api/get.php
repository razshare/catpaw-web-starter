<?php
use App\Components\LayoutComponent;
use CatPaw\Web\Attributes\Query;
use CatPaw\Web\Interfaces\RenderInterface;
return static function(
    RenderInterface $render,
    LayoutComponent $layout,
    #[Query]
    string $name = 'world',
) {
    $render->start();
    $layout->mount('Welcome', static function() use ($name) { ?>
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
    <?php });
} ?>