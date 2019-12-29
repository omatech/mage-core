<?php

namespace Omatech\Mage\Core\Adapters\Translations\Importers;

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Omatech\Mage\Core\Domains\Translations\Contracts\ImportTranslationInterface;
use Rap2hpoutre\FastExcel\FastExcel;

class ImporterFromExcel implements ImportTranslationInterface
{
    /**
     * @param string $path
     * @param string $locale
     * @return array
     */
    public function import(string $path, string $locale = ''): array
    {
        $sheetNames = $this->getSheets($path, $locale);
        $sheets = $this->importSheets($path, $sheetNames);

        return $this->parseTranslations($sheetNames, $sheets);
    }

    /**
     * @param string $path
     * @param string $locale
     * @return array
     */
    private function getSheets(string $path, string $locale = ''): array
    {
        $sheetNames = [];

        $reader = ReaderFactory::create(Type::XLSX);
        $reader->open($path);

        foreach ($reader->getSheetIterator() as $sheet) {
            array_push($sheetNames, $sheet->getName());
        }

        if ('' != $locale && in_array($locale, $sheetNames)) {
            $sheetNames = [0 => $locale];
        } elseif ('' != $locale && ! in_array($locale, $sheetNames)) {
            $sheetNames = [];
        }

        return $sheetNames;
    }

    /**
     * @param string $path
     * @param array $sheetNames
     * @return array
     */
    private function importSheets(string $path, array $sheetNames): array
    {
        $sheets = (new FastExcel());

        if (count($sheetNames) > 1) {
            $sheets = $sheets->importSheets($path)->toArray();
        } else {
            $sheets = [$sheets->sheet(key($sheetNames) + 1)->import($path)->toArray()];
        }

        return $sheets;
    }

    /**
     * @param array $sheetNames
     * @param array $sheets
     * @return array
     */
    private function parseTranslations(array $sheetNames, array $sheets): array
    {
        $translations = [];
        $parsedKeys = [];

        if ($sheetNames) {
            foreach ($sheets as $lang => $trans) {
                $translations[$sheetNames[$lang]] = $trans;
            }

            foreach ($translations as $lang => $keys) {
                foreach ($keys as $key) {
                    if ('' != $key['key2']) {
                        $parsedKeys[$key['key2']]['key'] = $key['key2'];
                        $parsedKeys[$key['key2']]['value'][$lang] = $key['value'];
                    }
                }
            }
        }

        return array_values($parsedKeys);
    }
}
