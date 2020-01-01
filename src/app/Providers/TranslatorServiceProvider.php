<?php

namespace Omatech\Mage\Core\Providers;

use Illuminate\Translation\Translator;
use Illuminate\Contracts\Translation\Loader;
use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Omatech\Mage\Core\Domains\Translations\Translation;
use Omatech\Mage\Core\Repositories\Translations\FindTranslation;
use Spatie\TranslationLoader\TranslationServiceProvider as SpatieTranslatorServiceProvider;

class TranslatorServiceProvider extends SpatieTranslatorServiceProvider
{
    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];
            $locale = $app['config']['app.locale'];
            $localeFallback = $app['config']['app.fallback_locale'];

            $translator = (new class($loader, $locale) extends Translator implements TranslatorContract {
                public function __construct(Loader $loader, string $locale)
                {
                    parent::__construct($loader, $locale);
                }

                public function get($key, array $replace = [], $locale = null, $fallback = true)
                {
                    $trans = Translation::find(new FindTranslation, ['key' => $key]);

                    if (!$trans->getId()) {
                        $trans->save();
                    }

                    return parent::get($key, $replace, $locale, $fallback);
                }

                public function insertKeyValue($value, $key = null, $params = [])
                {
                    if ($key == null) {
                        return $value;
                    }

                    $trans = Translation::find(new FindTranslation, ['key' => $key]);

                    if (!$trans->getId()) {
                        $trans->setTranslation(app()->getLocale(), $value);
                        $trans->save();
                    }

                    return $this->get($key, $params);
                }
            });

            $translator->setFallback($localeFallback);

            return $translator;
        });
    }
}
