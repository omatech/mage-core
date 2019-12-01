<?php

namespace Omatech\Mage\Core\Repositories\Translations;

use Omatech\Mage\Core\Repositories\TranslationBaseRepository;
use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\UniqueTranslationInterface;

class UniqueTranslation extends TranslationBaseRepository implements UniqueTranslationInterface
{
    public function unique(TranslationInterface $translation): bool
    {
        return $this->query()
            ->where('group', $translation->getGroup())
            ->where('key', $translation->getKey())
            ->where('id', '!=', $translation->getId())
            ->exists();
    }
}
