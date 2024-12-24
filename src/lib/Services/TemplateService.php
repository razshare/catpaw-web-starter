<?php
namespace App\Services;

use CatPaw\Core\Attributes\Provider;
use function CatPaw\Web\failure;
use CatPaw\Web\Interfaces\ResponseModifierInterface;
use function CatPaw\Web\success;
use const CatPaw\Web\TEXT_HTML;
use Smarty\Smarty;
use Throwable;

#[Provider]
class TemplateService {
    public function __construct(private Smarty $smarty) {
    }

    /**
     * Render a template.
     * @param  string                     $template   Template to use.
     * @param  array<string,mixed>|object $properties Properties to render the template with.
     * @return ResponseModifierInterface
     */
    public function render(string $template, array|object $properties = []):ResponseModifierInterface {
        try {
            $tpl = $this->smarty->createTemplate($template);

            if (!is_array($properties)) {
                $properties = (array)$properties;
            }

            foreach ($properties as $key => $value) {
                $tpl->assign($key, $value);
            }
            return success($tpl->fetch())->as(TEXT_HTML);
        } catch(Throwable $error) {
            return failure($error);
        }
    }
}