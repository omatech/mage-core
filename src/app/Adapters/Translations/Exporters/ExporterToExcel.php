<?php

namespace Omatech\Mage\Core\Adapters\Translations\Exporters;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Omatech\Mage\Core\Domains\Translations\Contracts\ExportTranslationInterface;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class ExporterToExcel implements ExportTranslationInterface
{
    /**
     * @param array $translations
     *
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\InvalidArgumentException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Writer\Exception\WriterNotOpenedException
     *
     * @return string
     */
    public function export(array $translations): string
    {
        return $this->toFile($translations);
    }

    /**
     * @param $translations
     *
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\InvalidArgumentException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Writer\Exception\WriterNotOpenedException
     *
     * @return string
     */
    private function toFile($translations): string
    {
        $path = base_path('storage/app/translations');
        File::makeDirectory($path, 0777, true, true);

        $date = Carbon::now('Europe/Madrid')->format('dmY_His');
        $path = storage_path('app/translations/'.$date.'_excel.xlsx');

        return (new FastExcel(new SheetCollection($translations)))->export($path, function ($sheets) {
            return [
                'key1'  => 'mage',
                'key2'  => $sheets['key'],
                'value' => $sheets['value'],
            ];
        });
    }
}
