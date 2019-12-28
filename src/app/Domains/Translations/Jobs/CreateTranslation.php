<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\CreateTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class CreateTranslation
{
    /**
     * @param Translation $translation
     * @return bool
     */
    public function make(Translation $translation): bool
    {
        return resolve(CreateTranslationInterface::class)->create($translation);
    }
}
