<?php

namespace Omatech\Mage\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Omatech\Mage\Core\Domains\Permissions\Permission;

class PermissionFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Permission::class;
    }
}