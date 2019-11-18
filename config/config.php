<?php

return [
    'bindings' => [
        'users' => Omatech\Mage\Core\Domains\Users\Contracts\UserInterface::class,
    ],
    'translations' => [
        'available_locales' => [
            [
                'locale'   => 'es',
                'name_key' => 'mage.translations.language.es',
            ], [
                'locale'   => 'ca',
                'name_key' => 'mage.translations.language.ca',
            ], [
                'locale'   => 'en',
                'name_key' => 'mage.translations.language.en',
            ],
        ],
    ],
];
