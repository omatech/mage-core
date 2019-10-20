<?php

namespace Omatech\Mage\Core\Adapters\Translations\Exporters;

use ZipArchive;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Omatech\Mage\Core\Domains\Translations\Contracts\ExportTranslationInterface;

class ExporterToArrayFile implements ExportTranslationInterface
{
    public function export($translations)
    {
        Storage::deleteDirectory("translations/tmp");

        foreach ($translations as $language => $values) {
            $groupedTranslations = $this->groupTranslations($values);
            $this->storeInFiles($language, $groupedTranslations);
        }

        $path = $this->zipFiles();

        Storage::deleteDirectory("translations/tmp");

        return $path;
    }

    private function groupTranslations($translations)
    {
        $groupedTranslations = [];

        foreach ($translations as $translation) {
            $groupedTranslations[$translation['group']][] = [$translation['key'] => $translation['value']];
        }

        return $groupedTranslations;
    }

    private function storeInFiles($language, $groupedTranslations)
    {
        foreach ($groupedTranslations as $group => $keys) {
            $file = "<?php\n\nreturn [\n\n";
            $file .= "    /*\n";
            $file .= "    |--------------------------------------------------------------------------\n";
            $file .= "    | $group\n";
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

    private function zipFiles()
    {
        $date = Carbon::now('Europe/Madrid')->format('dmY_His');
        $path = storage_path('app/translations/' . $date . '_laravel.zip');

        $this->zipDir(storage_path('app/translations/tmp'), $path);

        return $path;
    }

    private function zipDir($sourcePath, $outZipPath)
    {
        $pathInfo = pathInfo($sourcePath);
        $parentPath = $pathInfo['dirname'] . '/' . $pathInfo['basename'];
        $z = new ZipArchive();
        $z->open($outZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        self::folderToZip($sourcePath, $z, strlen("$parentPath/"));
        $z->close();
    }

    private static function folderToZip($folder, &$zipFile, $exclusiveLength)
    {
        $handle = opendir($folder);
        while (false !== $f = readdir($handle)) {
            if ($f != '.' && $f != '..') {
                $filePath = "$folder/$f";
                // Remove prefix from file path before add to zip.
                $localPath = substr($filePath, $exclusiveLength);
                if (is_file($filePath)) {
                    $zipFile->addFile($filePath, $localPath);
                } elseif (is_dir($filePath)) {
                    // Add sub-directory.
                    $zipFile->addEmptyDir($localPath);
                    self::folderToZip($filePath, $zipFile, $exclusiveLength);
                }
            }
        }
        closedir($handle);
    }
}
