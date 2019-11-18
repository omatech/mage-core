<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\FindTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class FindTranslation
{
    /**
     * @param string $key
     * @return mixed
     */
    public function make(string $key)
    {
        return app()->make(FindTranslationInterface::class)->find($key);
    }
}
