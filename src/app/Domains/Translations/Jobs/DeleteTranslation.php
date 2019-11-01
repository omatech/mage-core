<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\DeleteTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class DeleteTranslation
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
        return app()->make(DeleteTranslationInterface::class)->delete($translation);
    }
}
