<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\DeleteTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class DeleteTranslation
{
    /**
     * @param Translation $translation
     * @return bool
     */
    public function make(Translation $translation): bool
    {
        return resolve(DeleteTranslationInterface::class)->delete($translation);
    }
}
