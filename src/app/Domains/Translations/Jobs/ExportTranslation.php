<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\AllTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\ExportTranslationInterface;

class ExportTranslation
{
    public function make(
        AllTranslationInterface $allTranslationInterface,
        ExportTranslationInterface $exportTranslationInterface,
        $locales
    ) {
        $translations = $allTranslationInterface->get($locales);

        $parsedTranslations = [];

        foreach ($translations as $values) {
            foreach ($values as $key => $value) {
                if (array_key_exists($key, array_flip($locales))) {
                    $parsedTranslations[$key][] = [
                        'group' => $values['group'],
                        'key' => $values['group'] . '.' . $values['key'],
                        'value' => $value
                    ];
                }
            }
        }

        foreach ($parsedTranslations as &$translation) {
            $translation = collect($translation);
        }

        return $exportTranslationInterface->export($parsedTranslations);
    }
}
