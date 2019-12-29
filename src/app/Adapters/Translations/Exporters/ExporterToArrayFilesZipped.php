<?php

namespace Omatech\Mage\Core\Adapters\Translations\Exporters;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Omatech\Mage\Core\Domains\Translations\Contracts\ExportTranslationInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class ExporterToArrayFilesZipped implements ExportTranslationInterface
{
    /**
     * @param $translations
     * @return string
     */
    public function export(array $translations): string
    {
        Storage::deleteDirectory('translations/tmp');

        foreach ($translations as $language => $values) {
            $groupedTranslations = $this->groupTranslations($values->toArray());
            $this->storeInFiles($language, $groupedTranslations);
        }

        $path = $this->zipFiles();

        Storage::deleteDirectory('translations/tmp');

        return $path;
    }

    /**
     * @param array $translations
     * @return array
     */
    private function groupTranslations(array $translations): array
    {
        $groupedTranslations = [];

        foreach ($translations as $translation) {
            $key = str_replace($translation['group'].'.', '', $translation['key']);
            $groupedTranslations[$translation['group']][] = [$key => $translation['value']];
        }

        return $groupedTranslations;
    }

    /**
     * @param $language
     * @param $groupedTranslations
     */
    private function storeInFiles($language, $groupedTranslations): void
    {
        foreach ($groupedTranslations as $group => $keys) {
            $file = "<?php\n\nreturn [\n\n";
            $file .= "    /*\n";
            $file .= "    |--------------------------------------------------------------------------\n";
            $file .= '    | '.ucfirst($group)."\n";
            $file .= "    |--------------------------------------------------------------------------\n";
            $file .= "    */\n";

            Storage::append("translations/tmp/$language/$group.php", $file);

            foreach ($keys as $key) {
                $currentKey = key($key);
                $currentValue = $key[$currentKey];

                Storage::append("translations/tmp/$language/$group.php", "    '$currentKey' => '$currentValue',");
            }

            $file = "];\n";
            Storage::append("translations/tmp/$language/$group.php", $file);
        }
    }

    /**
     * @return string
     */
    private function zipFiles(): string
    {
        $date = Carbon::now('Europe/Madrid')->format('dmY_His');
        $path = storage_path('app/translations/'.$date.'_laravel.zip');

        $this->zipDir(storage_path('app/translations/tmp'), $path);

        return $path;
    }

    /**
     * @param $sourcePath
     * @param $outZipPath
     */
    private function zipDir($sourcePath, $outZipPath): void
    {
        $zip = new ZipArchive();
        $zip->open($outZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourcePath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (! $file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($sourcePath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();
    }
}
