<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface CreateTranslationInterface
{
    /**
     * @param TranslationInterface $translation
     * @return bool
     */
    public function create(TranslationInterface $translation): bool;
}
