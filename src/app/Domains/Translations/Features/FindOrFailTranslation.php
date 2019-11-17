<?php

namespace Omatech\Mage\Core\Domains\Translations\Features;

use Omatech\Mage\Core\Domains\Translations\Jobs\FindTranslation;
use Omatech\Mage\Core\Domains\Translations\Translation;

class FindOrFailTranslation
{
    public function make(string $key): Translation
    {
        return app()->make(FindTranslation::class)->make($key);
    }
}
