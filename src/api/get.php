<?php
use App\Template;
use CatPaw\Web\Attributes\Produces;
use CatPaw\Web\Attributes\Summary;

return 
#[Summary("Says hello.")]
#[Produces(200, 'text/html', 'A web page that says hello.', 'string')]
static fn (Template $template, string $name = 'world') 
    => $template->render('index.tpl', ['name' => $name]);