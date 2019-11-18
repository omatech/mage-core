<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface UpdateTranslationInterface
{
    /**
     * @param TranslationInterface $translation
     * @return bool
     */
    public function update(TranslationInterface $translation): bool;
}
