<?php

namespace Omatech\Mage\Core\Repositories\Translations;

use Omatech\Mage\Core\Domains\Translations\Contracts\ExistsTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;
use Omatech\Mage\Core\Repositories\TranslationBaseRepository;

class ExistsTranslation extends TranslationBaseRepository implements ExistsTranslationInterface
{
    /**
     * @param TranslationInterface $translation
     * @return bool
     */
    public function exists(TranslationInterface $translation): bool
    {
        return $this->query()
            ->where(static function ($q) use ($translation) {
                $q->where('group', $translation->getGroup())
                  ->where('key', $translation->getKey());
            })
            ->orWhere('id', $translation->getId())
            ->exists();
    }
}
