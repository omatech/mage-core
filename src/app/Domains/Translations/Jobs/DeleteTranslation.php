<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Translation;
use Omatech\Mage\Core\Domains\Translations\Contracts\DeleteTranslationInterface;

class DeleteTranslation
{
    /**
     * @param Translation $translation
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(Translation $translation): bool
    {
        return app()->make(DeleteTranslationInterface::class)->delete($translation);
    }
}
