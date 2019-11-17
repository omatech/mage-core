<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface FindTranslationInterface
{
    public function find(string $key): ?TranslationInterface;
}
