<?php

namespace Omatech\Mage\Core\Repositories\Translations;

use Omatech\Mage\Core\Domains\Translations\Contracts\AllTranslationInterface;
use Omatech\Mage\Core\Repositories\TranslationBaseRepository;

class AllTranslation extends TranslationBaseRepository implements AllTranslationInterface
{
    public function get($locales)
    {
        $select = ['id', 'group', 'key'];

        foreach ($locales as $locale) {
            $select[] = "text->$locale as $locale";
        }

        return $this->query()
            ->select($select)
            ->paginate()
            ->toArray();
    }
}
