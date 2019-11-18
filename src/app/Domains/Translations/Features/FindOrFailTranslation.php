<?php

namespace Omatech\Mage\Core\Domains\Translations\Features;

use Omatech\Mage\Core\Domains\Translations\Jobs\FindTranslation;
use Omatech\Mage\Core\Domains\Translations\Translation;

class FindOrFailTranslation
{
    /**
     * @param string $key
     * @return mixed
     */
    public function make(string $key)
    {
        return (new FindTranslation())->make($key);
    }
}
