<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\UpdateTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class UpdateTranslation
{
    /**
     * @param Translation $translation
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(Translation $translation): bool
    {
        return app()->make(UpdateTranslationInterface::class)->update($translation);
    }
}
