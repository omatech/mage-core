<?php

namespace Omatech\Mage\Core\Models;

use Spatie\TranslationLoader\LanguageLine as SpatieLanguageLine;

class LanguageLine extends SpatieLanguageLine
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('translation-loader.table_name'));
    }
}
