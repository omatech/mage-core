<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\FindTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class FindTranslation
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(string $key): ?Translation
    {
        return app()->make(FindTranslationInterface::class)->find($key);
    }
}
