<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface ExportTranslationInterface
{
    /**
     * @param array $translations
     * @return string
     */
    public function export(array $translations): string;
}
