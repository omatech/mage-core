<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

class AllTranslation
{
    public function make($all, array $locales)
    {
        return $all->get($locales);
    }
}
