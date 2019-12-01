<?php

namespace Omatech\Mage\Core\Providers\Bindings;

use Omatech\Mage\Core\Domains\Translations\Contracts\AllTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\CreateTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\DeleteTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\ExistsTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\FindTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\TranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\UniqueTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Contracts\UpdateTranslationInterface;
use Omatech\Mage\Core\Domains\Translations\Translation;
use Omatech\Mage\Core\Repositories\Translations\AllTranslation;
use Omatech\Mage\Core\Repositories\Translations\CreateTranslation;
use Omatech\Mage\Core\Repositories\Translations\DeleteTranslation;
use Omatech\Mage\Core\Repositories\Translations\ExistsTranslation;
use Omatech\Mage\Core\Repositories\Translations\FindTranslation;
use Omatech\Mage\Core\Repositories\Translations\UniqueTranslation;
use Omatech\Mage\Core\Repositories\Translations\UpdateTranslation;

trait TranslationsBindingTrait
{
    private function translationBindings()
    {
        $this->app->bind('mage.translations', function () {
            return $this->app->make(TranslationInterface::class);
        });

        $this->app->bind(TranslationInterface::class, Translation::class);
        $this->app->bind(AllTranslationInterface::class, AllTranslation::class);
        $this->app->bind(FindTranslationInterface::class, FindTranslation::class);
        $this->app->bind(CreateTranslationInterface::class, CreateTranslation::class);
        $this->app->bind(DeleteTranslationInterface::class, DeleteTranslation::class);
        $this->app->bind(ExistsTranslationInterface::class, ExistsTranslation::class);
        $this->app->bind(UpdateTranslationInterface::class, UpdateTranslation::class);
        $this->app->bind(UniqueTranslationInterface::class, UniqueTranslation::class);
    }
}
