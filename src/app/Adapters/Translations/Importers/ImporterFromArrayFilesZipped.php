<?php

namespace Omatech\Mage\Core\Adapters\Translations\Importers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Omatech\Mage\Core\Domains\Translations\Contracts\ImportTranslationInterface;
use ZipArchive;

class ImporterFromArrayFilesZipped implements ImportTranslationInterface
{
    /**
     * @param string $path
     * @param string $locale
     * @return array
     */
    public function import(string $path, string $locale = ''): array
    {
        Storage::deleteDirectory('translations/tmp');
        $unzipPath = storage_path('app/translations/tmp');

        $this->unzip($path, $unzipPath);

        $translations = $this->parseTranslations($unzipPath, $locale);

        Storage::deleteDirectory('translations/tmp');

        return $translations;
    }

    /**
     * @param string $path
     * @param string $unzipPath
     */
    public function unzip(string $path, string $unzipPath)
    {
        $zip = new ZipArchive;

        if ($zip->open($path) === true) {
            $zip->extractTo($unzipPath);
            $zip->close();
        }
    }

    /**
     * @param $files
     * @param $locale
     * @return array
     */
    private function parseFile($files, $locale)
    {
        $parsedFile = array_map(function ($file) use ($locale) {
            $parsedFile = str_replace(storage_path('app/translations/tmp'), '', $file);
            $parsedFile = str_replace('.php', '', $parsedFile);
            $parsedFile = preg_split('@/@', $parsedFile, null, PREG_SPLIT_NO_EMPTY);

            if ('' !== $locale && $parsedFile[0] != $locale) {
                return;
            }

            $parsedFile[] = include $file;

            return $parsedFile;
        }, $files);

        return array_filter($parsedFile);
    }

    /**
     * @param $parsedFile
     * @return mixed
     */
    private function joinArrayValues($parsedFile)
    {
        foreach ($parsedFile as &$locale) {
            foreach ($locale[array_key_last($locale)] as $key => $value) {
                if (is_array($value)) {
                    $value = Arr::dot($value);
                    foreach ($value as $arrKey => $arrValue) {
                        $locale[array_key_last($locale)][$key.'.'.$arrKey] = $arrValue;
                    }
                    unset($locale[array_key_last($locale)][$key]);
                }
            }
        }

        return $parsedFile;
    }

    /**
     * @param $unzipPath
     * @param $locale
     * @return array
     */
    private function parseTranslations($unzipPath, $locale)
    {
        $files = $this->getDirContents($unzipPath);
        $parsedFile = $this->parseFile($files, $locale);
        $parsedFile = $this->joinArrayValues($parsedFile);

        $translations = [];

        foreach ($parsedFile as $translation) {
            $group = array_slice($translation, 1, count($translation) - 2);
            $group = implode('.', $group);
            foreach ($translation[array_key_last($translation)] as $key => $value) {
                $translations[$group.'.'.$key]['key'] = $group.'.'.$key;
                $translations[$group.'.'.$key]['value'][$translation[array_key_first($translation)]] = $value;
            }
        }

        return array_values($translations);
    }

    /**
     * @param $dir
     * @param array $results
     * @return array
     */
    private function getDirContents($dir, &$results = [])
    {
        $files = scandir($dir);

        foreach ($files as $value) {
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if (! is_dir($path)) {
                $results[] = $path;
            } elseif ($value != '.' && $value != '..') {
                $this->getDirContents($path, $results);
            }
        }

        return $results;
    }
}
