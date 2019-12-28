<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface FindTranslationInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function find(array $params);
}
