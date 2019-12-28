<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\FindTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\ImportTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class ImportTranslation
{
    /**
     * @param FindTranslationInterface $find
     * @param ImportTranslationInterface $import
     * @param string $path
     * @param string $locale
     * @return bool
     */
    public function make(
        FindTranslationInterface $find,
        ImportTranslationInterface $import,
        string $path,
        string $locale = ''
    ) {
        $translations = $import->import($path, $locale);

        $results = array_map(function ($translation) use ($find) {
            return Translation::find($find, ['key' => $translation['key']])
                ->setTranslations($translation['value'])
                ->save();
        }, $translations);

        return count($results) > 0;
    }
}
