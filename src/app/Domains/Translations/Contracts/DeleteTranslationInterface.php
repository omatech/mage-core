<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface DeleteTranslationInterface
{
    /**
     * @param TranslationInterface $translation
     * @return bool
     */
    public function delete(TranslationInterface $translation): bool;
}
