<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface FindTranslationInterface
{
    /**
     * @param string $key
     * @return mixed
     */
    public function find(string $key);
}
