<?php

namespace Omatech\Mage\Core\Providers\Bindings;

use Omatech\Mage\Core\Domains\Users\Contracts\AllUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\CreateUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\DeleteUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\ExistsUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\FindUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UniqueUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UpdateUserInterface;
use Omatech\Mage\Core\Domains\Users\Contracts\UserInterface;
use Omatech\Mage\Core\Domains\Users\User;
use Omatech\Mage\Core\Repositories\Users\AllUser;
use Omatech\Mage\Core\Repositories\Users\CreateUser;
use Omatech\Mage\Core\Repositories\Users\DeleteUser;
use Omatech\Mage\Core\Repositories\Users\ExistsUser;
use Omatech\Mage\Core\Repositories\Users\FindUser;
use Omatech\Mage\Core\Repositories\Users\UniqueUser;
use Omatech\Mage\Core\Repositories\Users\UpdateUser;

trait UsersBindingTrait
{
    private function userBindings()
    {
        $this->app->bind('mage.users', function () {
            return resolve(UserInterface::class);
        });

        $this->app->bind(UserInterface::class, User::class);
        $this->app->bind(AllUserInterface::class, AllUser::class);
        $this->app->bind(FindUserInterface::class, FindUser::class);
        $this->app->bind(CreateUserInterface::class, CreateUser::class);
        $this->app->bind(DeleteUserInterface::class, DeleteUser::class);
        $this->app->bind(ExistsUserInterface::class, ExistsUser::class);
        $this->app->bind(UpdateUserInterface::class, UpdateUser::class);
        $this->app->bind(UniqueUserInterface::class, UniqueUser::class);
    }
}
