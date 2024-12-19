<?php
use const CatPaw\Web\APPLICATION_JSON;
use CatPaw\Web\Attributes\IgnoreOpenApi;
use CatPaw\Web\Interfaces\OpenApiInterface;
use function CatPaw\Web\success;
return #[IgnoreOpenApi] static fn (OpenApiInterface $oa) => success($oa->data())->as(APPLICATION_JSON);