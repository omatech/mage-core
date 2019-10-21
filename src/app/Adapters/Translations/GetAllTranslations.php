<?php

namespace Omatech\Mage\Core\Adapters\Translations;

use Omatech\Mage\Core\Repositories\TranslationRepository;

class GetAllTranslations extends TranslationRepository
{
    /**
     * @param $locales
     * @return array
     */
    public function get($locales): array
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
