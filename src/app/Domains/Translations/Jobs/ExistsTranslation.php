<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\ExistsTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class ExistsTranslation
{
    /**
     * @param Translation $translation
     * @return bool
     */
    public function make(Translation $translation): bool
    {
        return resolve(ExistsTranslationInterface::class)->exists($translation);
    }
}
