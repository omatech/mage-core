<?php

namespace Omatech\Mage\Core\Repositories\Translations;

use Illuminate\Support\Facades\DB;
use Omatech\Mage\Core\Domains\Translations\Contracts\FindTranslationInterface;
use Omatech\Mage\Core\Repositories\TranslationBaseRepository;

class FindTranslation extends TranslationBaseRepository implements FindTranslationInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function find(array $params)
    {
        $translation = $this->query()
            ->where(DB::raw("CONCAT(`group`, '.', `key`)"), $params['key'])
            ->first();

        if (null === $translation) {
            return app('mage.translations')::fromArray([
                'key' => $params['key'],
            ]);
        }

        $translation = app('mage.translations')::fromArray([
            'id'           => $translation->id,
            'key'          => $translation->group.'.'.$translation->key,
            'translations' => $translation->text,
            'sync_at'      => $translation->sync_at,
            'created_at'   => $translation->created_at,
            'updated_at'   => $translation->updated_at,
        ]);

        return $translation;
    }
}
