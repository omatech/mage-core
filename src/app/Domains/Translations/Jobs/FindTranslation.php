<?php

namespace Omatech\Mage\Core\Domains\Translations\Jobs;

use Omatech\Mage\Core\Domains\Translations\Contracts\FindTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;

class FindTranslation
{
    /**
     * @param int $id
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return Translation|null
     */
    public function make(int $id): ?Translation
    {
        return app()->make(FindTranslationInterface::class)->find($id);
    }
}
