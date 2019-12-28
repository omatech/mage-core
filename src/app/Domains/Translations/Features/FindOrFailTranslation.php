<?php

namespace Omatech\Mage\Core\Domains\Translations\Features;

use Omatech\Mage\Core\Domains\Translations\Contracts\FindTranslationInterface;

class FindOrFailTranslation
{
    /**
     * @param FindTranslationInterface $find
     * @param array $params
     * @return mixed
     */
    public function make(FindTranslationInterface $find, array $params)
    {
        return $find->find($params);
    }
}
