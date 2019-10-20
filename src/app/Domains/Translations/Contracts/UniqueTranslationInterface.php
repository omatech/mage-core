<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface UniqueTranslationInterface
{
    public function unique(TranslationInterface $translation): bool;
}
