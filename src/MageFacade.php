<?php

namespace Omatech\Mage\Core;

use Exception;
use Illuminate\Support\Facades\Facade;
use Omatech\Mage\Core\Facades\PermissionFacade;
use Omatech\Mage\Core\Facades\RoleFacade;
use Omatech\Mage\Core\Facades\TranslationFacade;
use Omatech\Mage\Core\Facades\UserFacade;

class MageFacade extends Facade
{
    public static function domain(string $domain)
    {
        switch ($domain) {
            case 'Permission':
                $facade = PermissionFacade::class;
                break;
            case 'Role':
                $facade = RoleFacade::class;
                break;
            case 'User':
                $facade = UserFacade::class;
                break;
            case 'Translation':
                $facade = TranslationFacade::class;
                break;
            default:
                throw new Exception;
        }

        return $facade;
    }
}
