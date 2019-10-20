<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Translation;
use Omatech\Mage\Core\Domains\Translations\Contracts\FindTranslationInterface;

class FindTranslation
{
    /**
     * @param int $id
     * @return Translation|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make(int $id): ?Translation
    {
        return app()->make(FindTranslationInterface::class)->find($id);
    }
}
