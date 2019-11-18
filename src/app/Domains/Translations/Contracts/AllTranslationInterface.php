<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface AllTranslationInterface
{
    /**
     * @param $locales
     * @return mixed
     */
    public function get($locales);
}
