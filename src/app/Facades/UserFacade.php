<?php

namespace Omatech\Mage\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Omatech\Mage\Core\Domains\Users\User;

class UserFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return User::class;
    }
}
