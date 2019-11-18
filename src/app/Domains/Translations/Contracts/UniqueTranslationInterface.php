<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface UniqueTranslationInterface
{
    /**
     * @param TranslationInterface $translation
     * @return bool
     */
    public function unique(TranslationInterface $translation): bool;
}
