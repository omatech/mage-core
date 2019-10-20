<?php

namespace Omatech\Mage\Core\Adapters\Translations\Exporters;

use Carbon\Carbon;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;
use Omatech\Mage\Core\Domains\Translations\Contracts\ExportTranslationInterface;

class ExporterToExcel implements ExportTranslationInterface
{
    public function export($translations)
    {
        return $this->toFile($translations);
    }

    private function toFile($translations)
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
