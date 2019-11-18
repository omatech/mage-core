<?php

namespace Omatech\Mage\Core;

use Exception;

class Mage
{
    public static function domain(string $domain)
    {
        switch ($domain) {
            case 'Permissions':
                $facade = app('mage.permissions');
                break;
            case 'Roles':
                $facade = app('mage.roles');
                break;
            case 'Users':
                $facade = app('mage.users');
                break;
            case 'Translations':
                $facade = app('mage.translations');
                break;
            default:
                throw new Exception();
        }

        return $facade;
    }
}
