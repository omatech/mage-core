<?php

namespace Omatech\Mage\Core\Repositories;

use Omatech\Lars\BaseRepository;
use Omatech\Mage\Core\Models\LanguageLine;

class TranslationBaseRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return LanguageLine::class;
    }
}
