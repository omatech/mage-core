<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\UniqueTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class UniqueTranslation
{
    /**
     * @param Translation $translation
     * @return bool
     */
    public function make(Translation $translation): bool
    {
        return resolve(UniqueTranslationInterface::class)->unique($translation);
    }
}
