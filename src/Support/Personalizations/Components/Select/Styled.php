<?php

namespace TasteUi\Support\Personalizations\Components\Select;

use TasteUi\Support\Personalizations\Contracts\Personalizable;
use TasteUi\Support\Personalizations\Traits\ShareablePersonalization;
use TasteUi\View\Components\Select\Styled as Component;

class Styled implements Personalizable
{
    use ShareablePersonalization;

    public function component(): string
    {
        return Component::class;
    }
}
