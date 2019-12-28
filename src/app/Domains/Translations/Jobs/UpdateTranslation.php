<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\UpdateTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class UpdateTranslation
{
    /**
     * @param Translation $translation
     * @return bool
     */
    public function make(Translation $translation): bool
    {
        return resolve(UpdateTranslationInterface::class)->update($translation);
    }
}
