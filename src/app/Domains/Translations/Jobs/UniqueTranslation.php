<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\UniqueTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class UniqueTranslation
{
    /**
     * @param Translation $translation
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return bool
     */
    public function make(Translation $translation): bool
    {
        return app()->make(UniqueTranslationInterface::class)->unique($translation);
    }
}
