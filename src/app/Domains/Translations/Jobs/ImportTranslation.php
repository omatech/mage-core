<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\ImportTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class ImportTranslation
{
    public function make(
        ImportTranslationInterface $importTranslationInterface,
        string $path,
        string $locale = ''
    ) {
        $translations = $importTranslationInterface->import($path, $locale);

        $results = array_map(function ($translation) {
            return Translation::find($translation['key'])
                ->setTranslations($translation['value'])
                ->save();
        }, $translations);

        return count($results) > 0;
    }
}
