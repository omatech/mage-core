<?php

namespace Omatech\Mage\Core\Domains\Translations\Contracts;

interface ExportTranslationInterface
{
    public function export(array $translations): string;
}
