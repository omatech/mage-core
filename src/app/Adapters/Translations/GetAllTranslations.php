<?php

namespace Omatech\Mage\Core\Adapters\Translations;

use Omatech\Mage\Core\Domains\Translations\Contracts\AllTranslationInterface;
use Omatech\Mage\Core\Repositories\TranslationBaseRepository;

class GetAllTranslations extends TranslationBaseRepository implements AllTranslationInterface
{
    /**
     * @param $locales
     * @return array
     */
    public function get(array $locales): array
    {
        $select = ['id', 'group', 'key'];

        foreach ($locales as $locale) {
            $select[] = "text->$locale as $locale";
        }

        return $this->query()
            ->select($select)
            ->get()
            ->toArray();
    }
}
