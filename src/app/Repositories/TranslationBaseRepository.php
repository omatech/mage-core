<?php

namespace Omatech\Mage\Core\Repositories;

use Omatech\Lars\BaseRepository;
use Omatech\Mage\Core\Models\LanguageLine;

class TranslationBaseRepository extends BaseRepository
{
    public function model(): string
    {
        return LanguageLine::class;
    }
}
