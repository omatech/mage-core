<?php

namespace Omatech\Mage\Core\Domains\Translations\Features;

use Omatech\Mage\Core\Domains\Translations\Jobs\FindTranslation;

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
