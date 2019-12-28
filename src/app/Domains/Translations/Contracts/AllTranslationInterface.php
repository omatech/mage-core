<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface AllTranslationInterface
{
    /**
     * @param array $locales
     * @return mixed
     */
    public function get(array $locales);
}
