<?php

namespace Omatech\Mage\Core\Adapters\Translations\Exporters;

use Carbon\Carbon;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;
use Omatech\Mage\Core\Domains\Translations\Contracts\ExportTranslationInterface;

class ExporterToExcel implements ExportTranslationInterface
{
    /**
     * @param array $translations
     * @return string
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\InvalidArgumentException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Writer\Exception\WriterNotOpenedException
     */
    public function export(array $translations): string
    {
        return $this->toFile($translations);
    }

    /**
     * @param $translations
     * @return string
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\InvalidArgumentException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Writer\Exception\WriterNotOpenedException
     */
    private function toFile($translations): string
    {
        $date = Carbon::now('Europe/Madrid')->format('dmY_His');
        $path = storage_path('app/translations/' . $date . '_excel.xlsx');

        return (new FastExcel(new SheetCollection($translations)))->export($path, function ($sheets) {
            return [
                'key1' => 'mage',
                'key2' => $sheets['key'],
                'value' => $sheets['value']
            ];
        });
    }
}
