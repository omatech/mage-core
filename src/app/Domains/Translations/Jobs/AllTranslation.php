<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

class AllTranslation
{
    /**
     * @param $all
     * @param array $locales
     *
     * @return mixed
     */
    public function make($all, array $locales)
    {
        return $all->get($locales);
    }
}
