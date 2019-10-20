<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Translation;
use Omatech\Mage\Core\Domains\Translations\Contracts\UniqueTranslationInterface;

class UniqueTranslation
{
    /**
     * @param Translation $translation
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(Translation $translation): bool
    {
        return app()->make(UniqueTranslationInterface::class)->unique($translation);
    }
}
