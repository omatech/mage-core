<?php

namespace Omatech\Mage\Core\Adapters\Translations;

use Omatech\Mage\Core\Domains\Translations\Contracts\AllTranslationInterface;
use Omatech\Mage\Core\Repositories\TranslationRepository;

class GetAllTranslations extends TranslationRepository implements AllTranslationInterface
{
    public function get($locales)
    {
        $select = ['id', 'group', 'key'];

        foreach ($locales as $locale) {
            $select[] = "text->$locale as $locale";
        }

        $translations = $this->query()
            ->select($select)
            ->get()
            ->toArray();

        return $translations;
    }
}
