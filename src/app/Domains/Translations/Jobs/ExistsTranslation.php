<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\ExistsTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class ExistsTranslation
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
        return app()->make(ExistsTranslationInterface::class)->exists($translation);
    }
}
